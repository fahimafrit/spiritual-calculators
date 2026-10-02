// Davison Relationship Chart Calculator - local server
// Serves public/ and exposes POST /api/davison (Swiss Ephemeris via the `sweph` package).
import http from 'node:http';
import fs from 'node:fs/promises';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import net from 'node:net';
import crypto from 'node:crypto';
import sweph from 'sweph';
import { DateTime } from 'luxon';
import tzlookup from 'tz-lookup';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const PUBLIC_DIR = path.join(__dirname, 'public');
const EPHE_DIR = path.join(__dirname, 'ephe');
const START_PORT = Number(process.env.PORT) || 3000;
const INSTANCE = crypto.randomBytes(3).toString('hex'); // identifies this server process in the UI
const STARTED = new Date();
let ACTIVE_PORT = START_PORT;
const C = sweph.constants;

sweph.set_ephe_path(EPHE_DIR);

class HttpError extends Error {
  constructor(status, message) { super(message); this.status = status; }
}

const norm360 = (x) => ((x % 360) + 360) % 360;
const rad = (d) => (d * Math.PI) / 180;
const deg = (r) => (r * 180) / Math.PI;

const HOUSE_SYSTEMS = {
  P: 'Placidus', K: 'Koch', W: 'Whole Sign', E: 'Equal', O: 'Porphyry',
  R: 'Regiomontanus', C: 'Campanus',
};
const AYANAMSAS = {
  lahiri: { id: C.SE_SIDM_LAHIRI, name: 'Lahiri' },
  fagan_bradley: { id: C.SE_SIDM_FAGAN_BRADLEY, name: 'Fagan/Bradley' },
  raman: { id: C.SE_SIDM_RAMAN, name: 'Raman' },
  krishnamurti: { id: C.SE_SIDM_KRISHNAMURTI, name: 'Krishnamurti' },
};

function bodyList(nodeType) {
  const mean = nodeType === 'mean';
  return [
    ['sun', 'Sun', C.SE_SUN],
    ['moon', 'Moon', C.SE_MOON],
    ['mercury', 'Mercury', C.SE_MERCURY],
    ['venus', 'Venus', C.SE_VENUS],
    ['mars', 'Mars', C.SE_MARS],
    ['jupiter', 'Jupiter', C.SE_JUPITER],
    ['saturn', 'Saturn', C.SE_SATURN],
    ['uranus', 'Uranus', C.SE_URANUS],
    ['neptune', 'Neptune', C.SE_NEPTUNE],
    ['pluto', 'Pluto', C.SE_PLUTO],
    ['node', 'North Node', mean ? C.SE_MEAN_NODE : C.SE_TRUE_NODE],
    ['chiron', 'Chiron', C.SE_CHIRON],
    ['lilith', 'Black Moon Lilith', C.SE_MEAN_APOG],
  ];
}

function houseOf(lon, cusps) {
  for (let i = 0; i < 12; i++) {
    const a = cusps[i];
    const b = cusps[(i + 1) % 12];
    const span = norm360(b - a);
    if (norm360(lon - a) < span) return i + 1;
  }
  return 1;
}

// Casts a full chart for one moment (jd in UT) and place.
function calcChart(jd, lat, lon, opt, warnings) {
  const sidFlag = opt.sidereal ? C.SEFLG_SIDEREAL : 0;
  const flags = C.SEFLG_SWIEPH | C.SEFLG_SPEED | sidFlag;
  const bodies = [];
  let moshier = false;

  for (const [key, name, id] of bodyList(opt.node)) {
    const r = sweph.calc_ut(jd, id, flags);
    if (r.flag < 0) {
      warnings.add(`${name} could not be calculated for this date with the installed ephemeris files.`);
      continue;
    }
    if (r.flag & C.SEFLG_MOSEPH) moshier = true;
    bodies.push({ key, name, lon: norm360(r.data[0]), lat: r.data[1], speed: r.data[3] });
    if (key === 'node') {
      bodies.push({ key: 'snode', name: 'South Node', lon: norm360(r.data[0] + 180), lat: -r.data[1], speed: r.data[3] });
    }
  }

  let hsysUsed = opt.hsys;
  let h = sweph.houses_ex(jd, sidFlag, lat, lon, hsysUsed);
  if (h.flag < 0) {
    warnings.add(`${HOUSE_SYSTEMS[opt.hsys]} houses cannot be computed at latitude ${lat.toFixed(2)}° (too close to a pole). Porphyry houses were used instead.`);
    hsysUsed = 'O';
    h = sweph.houses_ex(jd, sidFlag, lat, lon, hsysUsed);
  }
  const cusps = h.data.houses.map(norm360);
  const asc = norm360(h.data.points[0]);
  const mc = norm360(h.data.points[1]);
  const vertex = norm360(h.data.points[3]);

  const sun = bodies.find((b) => b.key === 'sun');
  const moon = bodies.find((b) => b.key === 'moon');
  if (sun && moon) {
    const dayChart = houseOf(sun.lon, cusps) >= 7;
    const pof = norm360(asc + (dayChart ? moon.lon - sun.lon : sun.lon - moon.lon));
    bodies.push({ key: 'pof', name: 'Part of Fortune', lon: pof, lat: 0, speed: 0 });
  }
  for (const b of bodies) b.house = houseOf(b.lon, cusps);

  return { bodies, cusps, asc, mc, vertex, hsysUsed, moshier };
}

// ---- Input handling -------------------------------------------------------

function parsePerson(p, label, warnings) {
  if (!p || typeof p !== 'object') throw new HttpError(400, `${label}: missing data.`);
  const name = String(p.name || label).slice(0, 60);
  if (!/^\d{4}-\d{2}-\d{2}$/.test(p.date || '')) throw new HttpError(400, `${label}: enter a birth date.`);
  if (!/^\d{2}:\d{2}(:\d{2})?$/.test(p.time || '')) throw new HttpError(400, `${label}: enter a birth time.`);
  const lat = Number(p.lat);
  const lon = Number(p.lon);
  if (!Number.isFinite(lat) || lat < -90 || lat > 90) throw new HttpError(400, `${label}: latitude must be between -90 and 90.`);
  if (!Number.isFinite(lon) || lon < -180 || lon > 180) throw new HttpError(400, `${label}: longitude must be between -180 and 180.`);

  let tz = String(p.tz || '').trim();
  if (!tz) {
    try { tz = tzlookup(lat, lon); }
    catch { throw new HttpError(400, `${label}: could not detect a time zone for these coordinates. Enter one (for example Asia/Dhaka).`); }
  }
  const [y, m, d] = p.date.split('-').map(Number);
  const [hh, mm, ss = 0] = p.time.split(':').map(Number);
  const local = DateTime.fromObject({ year: y, month: m, day: d, hour: hh, minute: mm, second: ss }, { zone: tz });
  if (!local.isValid) {
    throw new HttpError(400, `${label}: the date, time or time zone "${tz}" is not valid.`);
  }
  if (local.hour !== hh || local.minute !== mm || local.day !== d) {
    warnings.add(`${label}: ${p.date} ${p.time} does not exist in ${tz} (clocks skipped forward). It was read as ${local.toFormat('HH:mm')}.`);
  }
  const utc = local.toUTC();
  if (utc.year < 1800 || utc.year > 2399) {
    throw new HttpError(400, `${label}: dates must fall between 1800 and 2399 with the bundled ephemeris files.`);
  }
  const jd = sweph.julday(utc.year, utc.month, utc.day, utc.hour + utc.minute / 60 + utc.second / 3600, C.SE_GREG_CAL);
  return { name, lat, lon, tz, local, utc, jd };
}

function midpoint(a, b, method, warnings) {
  if (method === 'greatcircle') {
    const v = (p) => [Math.cos(rad(p.lat)) * Math.cos(rad(p.lon)), Math.cos(rad(p.lat)) * Math.sin(rad(p.lon)), Math.sin(rad(p.lat))];
    const va = v(a), vb = v(b);
    const s = [va[0] + vb[0], va[1] + vb[1], va[2] + vb[2]];
    const len = Math.hypot(...s);
    if (len > 1e-9) {
      return { lat: deg(Math.asin(s[2] / len)), lon: deg(Math.atan2(s[1], s[0])) };
    }
    warnings.add('The two birthplaces are almost exactly opposite each other, so a great-circle midpoint is undefined. The arithmetic midpoint was used.');
  }
  const lat = (a.lat + b.lat) / 2;
  const diff = ((b.lon - a.lon + 540) % 360) - 180; // shortest signed arc
  const lon = ((a.lon + diff / 2 + 540) % 360) - 180;
  return { lat, lon };
}

function jdToUtc(jd) {
  const ms = (jd - 2440587.5) * 86400000;
  return DateTime.fromMillis(Math.round(ms), { zone: 'utc' });
}

function compute(body) {
  const warnings = new Set();
  const A = parsePerson(body.a, 'Person A', warnings);
  const B = parsePerson(body.b, 'Person B', warnings);
  const o = body.options || {};

  const hsys = HOUSE_SYSTEMS[o.houseSystem] ? o.houseSystem : 'P';
  const sidereal = o.zodiac && o.zodiac !== 'tropical' && AYANAMSAS[o.zodiac];
  const opt = { hsys, node: o.node === 'mean' ? 'mean' : 'true', sidereal: Boolean(sidereal) };
  if (sidereal) sweph.set_sid_mode(AYANAMSAS[o.zodiac].id, 0, 0);

  // --- The Davison method: midpoint in time (UT) and midpoint in space ---
  const jdMid = (A.jd + B.jd) / 2;
  const mid = midpoint(A, B, o.midpoint === 'greatcircle' ? 'greatcircle' : 'arithmetic', warnings);
  const chart = calcChart(jdMid, mid.lat, mid.lon, opt, warnings);

  const midUtc = jdToUtc(jdMid);
  let midTz = 'UTC';
  try { midTz = tzlookup(mid.lat, mid.lon); } catch { /* keep UTC */ }
  const midLocal = midUtc.setZone(midTz);

  const natal = (P) => {
    const c = calcChart(P.jd, P.lat, P.lon, opt, warnings);
    const pick = (k) => c.bodies.find((b) => b.key === k)?.lon ?? null;
    return { sun: pick('sun'), moon: pick('moon'), asc: c.asc };
  };
  const summary = (P) => ({
    name: P.name, tz: P.tz, lat: P.lat, lon: P.lon,
    local: P.local.toFormat('yyyy-LL-dd HH:mm'),
    offset: P.local.toFormat('ZZ'),
    utc: P.utc.toFormat('yyyy-LL-dd HH:mm:ss'),
    ...natal(P),
  });

  if (chart.moshier) {
    warnings.add('Some ephemeris files were not found, so the built-in Moshier ephemeris was used. Positions remain accurate to about an arcsecond for the planets, and Chiron is unavailable. Run "npm run ephe" to install the files.');
  }

  return {
    meta: {
      engine: 'Swiss Ephemeris ' + (typeof sweph.version === 'function' ? sweph.version() : ''),
      ephemeris: chart.moshier ? 'Moshier (built-in)' : 'Swiss Ephemeris data files',
      houseSystem: HOUSE_SYSTEMS[hsys],
      houseSystemUsed: HOUSE_SYSTEMS[chart.hsysUsed],
      zodiac: sidereal ? `Sidereal (${AYANAMSAS[o.zodiac].name})` : 'Tropical',
      ayanamsa: sidereal ? sweph.get_ayanamsa_ut(jdMid) : null,
      nodeType: opt.node,
      midpointMethod: o.midpoint === 'greatcircle' ? 'Great-circle' : 'Arithmetic',
      server: { instance: INSTANCE, port: ACTIVE_PORT },
      warnings: [...warnings],
    },
    persons: [summary(A), summary(B)],
    davison: {
      jd: jdMid,
      utc: midUtc.toFormat('yyyy-LL-dd HH:mm:ss'),
      local: midLocal.toFormat('yyyy-LL-dd HH:mm:ss'),
      tz: midTz,
      offset: midLocal.toFormat('ZZ'),
      lat: mid.lat,
      lon: mid.lon,
    },
    chart: {
      bodies: chart.bodies,
      cusps: chart.cusps,
      asc: chart.asc,
      mc: chart.mc,
      vertex: chart.vertex,
    },
  };
}

// ---- HTTP -----------------------------------------------------------------

const MIME = {
  '.html': 'text/html; charset=utf-8', '.js': 'text/javascript; charset=utf-8', '.css': 'text/css; charset=utf-8',
  '.svg': 'image/svg+xml', '.json': 'application/json', '.png': 'image/png', '.ico': 'image/x-icon',
};

function readBody(req, limit = 100_000) {
  return new Promise((resolve, reject) => {
    let size = 0;
    const chunks = [];
    req.on('data', (c) => {
      size += c.length;
      if (size > limit) { reject(new HttpError(413, 'Request too large.')); req.destroy(); return; }
      chunks.push(c);
    });
    req.on('end', () => resolve(Buffer.concat(chunks).toString('utf8')));
    req.on('error', reject);
  });
}

const send = (res, status, body, type = 'application/json; charset=utf-8') => {
  res.writeHead(status, { 'Content-Type': type, 'Cache-Control': 'no-store', Connection: 'close' });
  res.end(body);
};

// Only local pages may call the API: the page served by this server, another local dev server
// (for example VS Code Live Server), or index.html opened straight from disk (Origin: null).
const ALLOWED_ORIGIN = /^(null|https?:\/\/(localhost|127\.0\.0\.1|\[::1\])(:\d+)?)$/;

const handler = async (req, res) => {
  const t0 = Date.now();
  const origin = req.headers.origin;
  if (origin && ALLOWED_ORIGIN.test(origin)) {
    res.setHeader('Access-Control-Allow-Origin', origin);
    res.setHeader('Access-Control-Allow-Headers', 'Content-Type');
    res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
    res.setHeader('Vary', 'Origin');
  }
  if (req.method === 'OPTIONS') { res.writeHead(204); res.end(); return; }
  res.on('finish', () => {
    console.log(`  ${new Date().toTimeString().slice(0, 8)}  ${req.method} ${(req.url || '').split('?')[0]}  ${res.statusCode}  ${Date.now() - t0} ms`);
  });
  try {
    const url = new URL(req.url, `http://${req.headers.host || 'localhost'}`);

    if (url.pathname === '/api/health') {
      return send(res, 200, JSON.stringify({ ok: true, instance: INSTANCE, pid: process.pid, port: ACTIVE_PORT, started: STARTED.toISOString() }));
    }

    if (req.method === 'POST' && url.pathname === '/api/davison') {
      let payload;
      try { payload = JSON.parse(await readBody(req)); }
      catch (e) { if (e instanceof HttpError) throw e; throw new HttpError(400, 'Invalid request body.'); }
      return send(res, 200, JSON.stringify(compute(payload)));
    }

    if (req.method !== 'GET' && req.method !== 'HEAD') throw new HttpError(405, 'Method not allowed.');

    let rel = decodeURIComponent(url.pathname);
    if (rel === '/') rel = '/index.html';
    const file = path.normalize(path.join(PUBLIC_DIR, rel));
    if (!file.startsWith(PUBLIC_DIR)) throw new HttpError(403, 'Forbidden.');
    try {
      const data = await fs.readFile(file);
      return send(res, 200, data, MIME[path.extname(file)] || 'application/octet-stream');
    } catch {
      throw new HttpError(404, 'Not found.');
    }
  } catch (err) {
    const status = err instanceof HttpError ? err.status : 500;
    if (status === 500) console.error(err);
    send(res, status, JSON.stringify({ error: status === 500 ? 'Calculation failed: ' + err.message : err.message }));
  }
};

// --- start-up: find a free port (checking IPv4 and IPv6, since "localhost" can resolve to either) ---
const portInUse = (port) => new Promise((resolve) => {
  const tryHost = (host) => new Promise((done) => {
    const sock = net.connect({ port, host });
    const finish = (busy) => { sock.destroy(); done(busy); };
    sock.setTimeout(400, () => finish(false));
    sock.once('connect', () => finish(true));
    sock.once('error', () => finish(false));
  });
  Promise.all([tryHost('127.0.0.1'), tryHost('::1')]).then(([a, b]) => resolve(a || b));
});

let port = START_PORT;
while (await portInUse(port)) {
  console.log(`  Port ${port} is already used by another program, trying ${port + 1}...`);
  port += 1;
  if (port > START_PORT + 20) { console.error('  No free port found. Close other servers and try again.'); process.exit(1); }
}
ACTIVE_PORT = port;

const listenOn = (host) => new Promise((resolve) => {
  const srv = http.createServer(handler);
  srv.on('error', () => resolve(false)); // e.g. IPv6 not available: fine
  srv.listen(port, host, () => resolve(true));
});
const ok4 = await listenOn('127.0.0.1');
const ok6 = await listenOn('::1'); // so http://localhost works whichever address it resolves to
if (!ok4 && !ok6) { console.error('  Could not start the server on port ' + port + '.'); process.exit(1); }

process.on('uncaughtException', (e) => console.error('Unexpected error:', e));
process.on('unhandledRejection', (e) => console.error('Unexpected error:', e));

console.log(`\n  Davison calculator running at  http://localhost:${port}\n  Server id ${INSTANCE}  (press Ctrl+C to stop)\n`);
