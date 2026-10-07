<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   SWISS EPHEMERIS WRAPPER (shared by every astrology calculator)
   Runs the Swiss Ephemeris command-line program (swetest) and turns
   its output into PHP arrays. Files it needs, outside the web root:

     storage/bin/swetest-linux      (Linux / Hostinger)
     storage/bin/swetest.exe        (Windows / XAMPP)
     storage/ephemeris/*.se1        (sepl_18, semo_18, seas_18)

   Set SPIRITUAL_STORAGE before the bootstrap loads to keep these
   files in another folder. Default: <repo>/storage.
   ════════════════════════════════════════════════════════════════════ */

const SC_SWE_HOUSE_SYSTEMS = [
    'P' => 'Placidus', 'K' => 'Koch', 'W' => 'Whole Sign', 'E' => 'Equal',
    'O' => 'Porphyry', 'R' => 'Regiomontanus', 'C' => 'Campanus',
];

const SC_SWE_AYANAMSAS = [
    'lahiri' => ['id' => 1, 'name' => 'Lahiri'],
    'fagan_bradley' => ['id' => 0, 'name' => 'Fagan/Bradley'],
    'raman' => ['id' => 3, 'name' => 'Raman'],
    'krishnamurti' => ['id' => 5, 'name' => 'Krishnamurti'],
];

function sc_storage_dir(): string
{
    $dir = defined('SPIRITUAL_STORAGE') ? (string) SPIRITUAL_STORAGE : SPIRITUAL_ROOT . '/storage';
    $dir = rtrim($dir, '/\\');

    return DIRECTORY_SEPARATOR === '\\' ? str_replace('/', '\\', $dir) : $dir;
}

function sc_swe_binary(): string
{
    $name = PHP_OS_FAMILY === 'Windows' ? 'swetest.exe' : 'swetest-linux';
    $path = sc_storage_dir() . '/bin/' . $name;

    if (!is_file($path)) {
        throw new RuntimeException('Swiss Ephemeris program not found: ' . $path);
    }
    if (PHP_OS_FAMILY !== 'Windows' && !is_executable($path)) {
        @chmod($path, 0755);
    }

    return $path;
}

function sc_swe_ephemeris_dir(): string
{
    $dir = sc_storage_dir() . '/ephemeris';

    foreach (['sepl_18.se1', 'semo_18.se1', 'seas_18.se1'] as $file) {
        if (!is_file($dir . '/' . $file)) {
            throw new RuntimeException('Ephemeris file missing: ' . $dir . '/' . $file);
        }
    }

    return $dir;
}

/** Runs swetest with the given arguments and returns its standard output. */
function sc_swe_run(array $args): string
{
    $binary = sc_swe_binary();

    if (function_exists('proc_open')) {
        $process = @proc_open(
            array_merge([$binary], $args),
            [1 => ['pipe', 'w'], 2 => ['pipe', 'w']],
            $pipes,
            null,
            null,
            ['bypass_shell' => true]
        );
        if (is_resource($process)) {
            $stdout = (string) stream_get_contents($pipes[1]);
            $stderr = (string) stream_get_contents($pipes[2]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            $code = proc_close($process);
            if ($code !== 0 && trim($stdout) === '') {
                throw new RuntimeException('swetest failed (' . $code . '): ' . trim($stderr));
            }
            return $stdout;
        }
    }

    if (function_exists('exec')) {
        $command = escapeshellarg($binary);
        foreach ($args as $arg) {
            $command .= ' ' . escapeshellarg($arg);
        }
        $lines = [];
        $code = 0;
        exec($command . ' 2>&1', $lines, $code);
        $stdout = implode("\n", $lines);
        if ($code !== 0 && trim($stdout) === '') {
            throw new RuntimeException('swetest failed (' . $code . ')');
        }
        return $stdout;
    }

    throw new RuntimeException('Neither proc_open nor exec is available.');
}

function sc_swe_number(float $value): string
{
    return sprintf('%.9F', $value);
}

function sc_swe_norm360(float $x): float
{
    return fmod(fmod($x, 360.0) + 360.0, 360.0);
}

/** Which house (1-12) a longitude falls in. */
function sc_swe_house_of(float $lon, array $cusps): int
{
    for ($i = 0; $i < 12; $i++) {
        $a = $cusps[$i];
        $b = $cusps[($i + 1) % 12];
        $span = sc_swe_norm360($b - $a);
        if (sc_swe_norm360($lon - $a) < $span) {
            return $i + 1;
        }
    }
    return 1;
}

/**
 * Casts a chart for one moment (jd in UT) and place.
 *
 * $opt: hsys (house letter), node ('true'|'mean'), sidereal (ayanamsa key or '')
 * $full false returns only Sun, Moon and the angles (used for natal summaries).
 *
 * Returns: bodies, cusps, asc, mc, vertex, hsysUsed
 */
function sc_swe_chart(float $jd, float $lat, float $lon, array $opt, array &$warnings, bool $full = true): array
{
    $sidereal = ($opt['sidereal'] ?? '') !== '' ? SC_SWE_AYANAMSAS[$opt['sidereal']] ?? null : null;
    $nodeLetter = ($opt['node'] ?? 'true') === 'mean' ? 'm' : 't';
    $hsysUsed = (string) ($opt['hsys'] ?? 'P');

    $list = [
        ['sun', 'Sun', 'Sun'], ['moon', 'Moon', 'Moon'], ['mercury', 'Mercury', 'Mercury'],
        ['venus', 'Venus', 'Venus'], ['mars', 'Mars', 'Mars'], ['jupiter', 'Jupiter', 'Jupiter'],
        ['saturn', 'Saturn', 'Saturn'], ['uranus', 'Uranus', 'Uranus'], ['neptune', 'Neptune', 'Neptune'],
        ['pluto', 'Pluto', 'Pluto'],
        ['node', 'North Node', $nodeLetter === 'm' ? 'mean Node' : 'true Node'],
        ['chiron', 'Chiron', 'Chiron'],
        ['lilith', 'Black Moon Lilith', 'mean Apogee'],
    ];
    $letters = $full ? '0123456789' . $nodeLetter . 'DA' : '01';
    if (!$full) {
        $list = array_slice($list, 0, 2);
    }

    $run = function (string $house) use ($jd, $lat, $lon, $letters, $sidereal): string {
        $args = [
            '-bj' . sc_swe_number($jd), '-ut', '-p' . $letters, '-fPlbs', '-g,', '-eswe',
            '-edir' . sc_swe_ephemeris_dir(),
            '-house' . sc_swe_number($lon) . ',' . sc_swe_number($lat) . ',' . $house,
        ];
        $args[] = '-head';
        if ($sidereal !== null) {
            $args[] = '-sid' . $sidereal['id'];
        }
        return sc_swe_run($args);
    };

    $out = $run($hsysUsed);
    if (stripos($out, 'error: House method') !== false) {
        $warnings[$hsysUsed . '-polar'] = (SC_SWE_HOUSE_SYSTEMS[$hsysUsed] ?? 'The chosen')
            . ' houses cannot be computed at latitude ' . number_format($lat, 2, '.', '')
            . '° (too close to a pole). Porphyry houses were used instead.';
        $hsysUsed = 'O';
        $out = $run($hsysUsed);
    }

    $found = [];
    $cusps = [];
    $points = [];

    foreach (preg_split('/\r\n|\r|\n/', $out) as $line) {
        if (preg_match('/^house\s+(\d+)\s*,\s*(-?\d+(?:\.\d+)?)/', $line, $m)) {
            $cusps[(int) $m[1] - 1] = (float) $m[2];
        } elseif (preg_match('/^(Ascendant|MC|Vertex)\s*,\s*(-?\d+(?:\.\d+)?)/', $line, $m)) {
            $points[$m[1]] = (float) $m[2];
        } elseif (preg_match('/^(Sun|Moon|Mercury|Venus|Mars|Jupiter|Saturn|Uranus|Neptune|Pluto|true Node|mean Node|Chiron|mean Apogee)\s*,\s*(-?\d+(?:\.\d+)?)\s*,\s*(-?\d+(?:\.\d+)?)\s*,\s*(-?\d+(?:\.\d+)?)/', $line, $m)) {
            $found[$m[1]] = ['lon' => (float) $m[2], 'lat' => (float) $m[3], 'speed' => (float) $m[4]];
        }
    }

    if (count($cusps) !== 12 || !isset($points['Ascendant'], $points['MC'])) {
        throw new RuntimeException('Could not read house data from swetest.');
    }
    ksort($cusps);
    $cusps = array_values(array_map('sc_swe_norm360', $cusps));
    $asc = sc_swe_norm360($points['Ascendant']);
    $mc = sc_swe_norm360($points['MC']);
    $vertex = sc_swe_norm360($points['Vertex'] ?? 0.0);

    $bodies = [];
    foreach ($list as [$key, $name, $sweName]) {
        if (!isset($found[$sweName])) {
            $warnings[$key . '-missing'] = $name . ' could not be calculated for this date with the installed ephemeris files.';
            continue;
        }
        $p = $found[$sweName];
        $bodies[] = ['key' => $key, 'name' => $name, 'lon' => sc_swe_norm360($p['lon']), 'lat' => $p['lat'], 'speed' => $p['speed']];
        if ($key === 'node') {
            $bodies[] = ['key' => 'snode', 'name' => 'South Node', 'lon' => sc_swe_norm360($p['lon'] + 180.0), 'lat' => -$p['lat'], 'speed' => $p['speed']];
        }
    }

    if ($full) {
        $sun = null;
        $moon = null;
        foreach ($bodies as $b) {
            if ($b['key'] === 'sun') {
                $sun = $b;
            } elseif ($b['key'] === 'moon') {
                $moon = $b;
            }
        }
        if ($sun !== null && $moon !== null) {
            $dayChart = sc_swe_house_of($sun['lon'], $cusps) >= 7;
            $pof = sc_swe_norm360($asc + ($dayChart ? $moon['lon'] - $sun['lon'] : $sun['lon'] - $moon['lon']));
            $bodies[] = ['key' => 'pof', 'name' => 'Part of Fortune', 'lon' => $pof, 'lat' => 0.0, 'speed' => 0.0];
        }
    }
    foreach ($bodies as $i => $b) {
        $bodies[$i]['house'] = sc_swe_house_of($b['lon'], $cusps);
    }

    return [
        'bodies' => $bodies, 'cusps' => $cusps, 'asc' => $asc, 'mc' => $mc, 'vertex' => $vertex,
        'hsysUsed' => $hsysUsed,
    ];
}

/** Ayanamsa in degrees for a sidereal zodiac at a moment (jd in UT). */
function sc_swe_ayanamsa(float $jd, string $ayanamsaKey): ?float
{
    $sidereal = SC_SWE_AYANAMSAS[$ayanamsaKey] ?? null;
    if ($sidereal === null) {
        return null;
    }

    $out = sc_swe_run([
        '-bj' . sc_swe_number($jd), '-ut', '-p0', '-fPl', '-g,', '-eswe',
        '-edir' . sc_swe_ephemeris_dir(), '-sid' . $sidereal['id'], '-nonut',
    ]);

    if (preg_match("/ayanamsa\s*=\s*(\d+)[^\d]+(\d+)'\s*([\d.]+)/i", $out, $m)) {
        return (float) $m[1] + (float) $m[2] / 60 + (float) $m[3] / 3600;
    }

    return null;
}


/** Tropical longitude of the Sun in degrees (0-360) at a moment (jd in UT). */
function sc_swe_sun(float $jd): float
{
    $out = sc_swe_run([
        '-bj' . sc_swe_number($jd), '-ut', '-p0', '-fPl', '-g,', '-eswe',
        '-edir' . sc_swe_ephemeris_dir(), '-head',
    ]);

    if (!preg_match('/^Sun\s*,\s*(-?\d+(?:\.\d+)?)/m', $out, $m)) {
        throw new RuntimeException('Could not read the Sun position from swetest.');
    }

    return sc_swe_norm360((float) $m[1]);
}
