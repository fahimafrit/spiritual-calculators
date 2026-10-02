// Downloads the Swiss Ephemeris data files (1800-2399) into ./ephe
// Safe to run repeatedly: files that already exist are skipped. Never fails the install.
import fs from 'node:fs/promises';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const FILES = ['sepl_18.se1', 'semo_18.se1', 'seas_18.se1'];
const BASE = 'https://raw.githubusercontent.com/aloistr/swisseph/master/ephe/';
const dir = path.join(path.dirname(fileURLToPath(import.meta.url)), '..', 'ephe');

await fs.mkdir(dir, { recursive: true });
for (const f of FILES) {
  const p = path.join(dir, f);
  try {
    const st = await fs.stat(p);
    if (st.size > 100000) { console.log(`ok   ${f} (already present)`); continue; }
  } catch { /* not there yet */ }
  process.stdout.write(`get  ${f} ... `);
  try {
    const r = await fetch(BASE + f);
    if (!r.ok) throw new Error('HTTP ' + r.status);
    const buf = Buffer.from(await r.arrayBuffer());
    await fs.writeFile(p, buf);
    console.log(`${Math.round(buf.length / 1024)} KB`);
  } catch (e) {
    console.log(`FAILED (${e.message})`);
    console.log('     Download it by hand into the ephe/ folder from:');
    console.log('     https://github.com/aloistr/swisseph/tree/master/ephe');
  }
}
process.exit(0);
