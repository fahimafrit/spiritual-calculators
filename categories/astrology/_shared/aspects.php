<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   ASTROLOGY CORE — ASPECTS & BALANCE (PHP)
   Shared by every astrology calculator that needs aspect patterns
   and element/mode balance. Pure functions only — no output, no HTTP,
   no HTML, no interpretation text.
   ════════════════════════════════════════════════════════════════════ */

/** Aspect definitions: key => [angle, orb, major] */
function sc_aspect_defs(): array
{
    return [
        'conjunction'    => [0,   8, true],
        'opposition'     => [180, 8, true],
        'trine'          => [120, 7, true],
        'square'         => [90,  7, true],
        'sextile'        => [60,  5, true],
        'quincunx'       => [150, 3, false],
        'semisextile'    => [30,  2, false],
        'semisquare'     => [45,  2, false],
        'sesquisquare'   => [135, 2, false],
    ];
}

/** Aspect bodies: ten planets + node, chiron, lilith, pof, then Ascendant and Midheaven last. */
function sc_aspect_bodies(): array
{
    return ['sun', 'moon', 'mercury', 'venus', 'mars', 'jupiter', 'saturn', 'uranus', 'neptune', 'pluto', 'node', 'chiron', 'lilith', 'pof', 'asc', 'mc'];
}

/** Ten planets only (for element/mode balance). */
function sc_planet_keys(): array
{
    return ['sun', 'moon', 'mercury', 'venus', 'mars', 'jupiter', 'saturn', 'uranus', 'neptune', 'pluto'];
}

/** Shortest angular separation between two longitudes. */
function sc_sep(float $a, float $b): float
{
    return abs(fmod(fmod($a - $b + 540, 360) + 360, 360) - 180);
}

/**
 * Compute aspects for a chart.
 *
 * @param array $chart Chart array as returned by sc_swe_chart (needs bodies, asc, mc)
 * @param bool $includeMinor Include minor aspects
 * @return array { points: [...], aspects: [...] }
 */
function sc_compute_aspects(array $chart, bool $includeMinor): array
{
    $bodies = sc_aspect_bodies();
    $defs = sc_aspect_defs();

    // Build points list
    $points = [];
    foreach ($chart['bodies'] as $body) {
        if (in_array($body['key'], $bodies, true)) {
            $points[] = [
                'key' => $body['key'],
                'name' => $body['name'],
                'lon' => $body['lon'],
                'speed' => $body['speed'],
            ];
        }
    }
    $points[] = ['key' => 'asc', 'name' => 'Ascendant', 'lon' => $chart['asc'], 'speed' => 0];
    $points[] = ['key' => 'mc', 'name' => 'Midheaven', 'lon' => $chart['mc'], 'speed' => 0];

    // Filter aspects by major/minor
    $aspects = [];
    foreach ($defs as $key => $def) {
        if ($def[2] || $includeMinor) {
            $aspects[$key] = $def;
        }
    }

    $out = [];
    $n = count($points);
    for ($i = 0; $i < $n; $i++) {
        for ($j = $i + 1; $j < $n; $j++) {
            $A = $points[$i];
            $B = $points[$j];

            // Skip asc-mc pairs
            if (in_array($A['key'], ['asc', 'mc'], true) && in_array($B['key'], ['asc', 'mc'], true)) {
                continue;
            }

            $d = sc_sep($A['lon'], $B['lon']);

            // Find best matching aspect
            $best = null;
            $bestOrb = null;
            foreach ($aspects as $key => $def) {
                $orb = abs($d - $def[0]);
                if ($orb <= $def[1] && ($bestOrb === null || $orb < $bestOrb)) {
                    $best = $key;
                    $bestOrb = $orb;
                }
            }

            if ($best === null) {
                continue;
            }

            // Applying/separating test
            $dt = 0.01; // days
            $d2 = sc_sep($A['lon'] + $A['speed'] * $dt, $B['lon'] + $B['speed'] * $dt);
            $still = $A['speed'] === 0 && $B['speed'] === 0;
            $applying = $still ? null : (abs($d2 - $defs[$best][0]) < $bestOrb);

            $out[] = [
                'i' => $i,
                'j' => $j,
                'aspect' => $best,
                'orb' => $bestOrb,
                'applying' => $applying,
            ];
        }
    }

    return ['points' => $points, 'aspects' => $out];
}

/**
 * Compute element and mode balance for the ten planets.
 *
 * @param array $chart Chart array as returned by sc_swe_chart
 * @return array { elements: {Fire: n, Earth: n, Air: n, Water: n}, modes: {Cardinal: n, Fixed: n, Mutable: n} }
 */
function sc_element_mode_balance(array $chart): array
{
    $planetKeys = sc_planet_keys();

    $signElements = ['Fire', 'Earth', 'Air', 'Water', 'Fire', 'Earth', 'Air', 'Water', 'Fire', 'Earth', 'Air', 'Water'];
    $signModes = ['Cardinal', 'Fixed', 'Mutable', 'Cardinal', 'Fixed', 'Mutable', 'Cardinal', 'Fixed', 'Mutable', 'Cardinal', 'Fixed', 'Mutable'];

    $elements = ['Fire' => 0, 'Earth' => 0, 'Air' => 0, 'Water' => 0];
    $modes = ['Cardinal' => 0, 'Fixed' => 0, 'Mutable' => 0];

    foreach ($chart['bodies'] as $body) {
        if (!in_array($body['key'], $planetKeys, true)) {
            continue;
        }
        $sign = (int) floor(fmod(fmod($body['lon'], 360) + 360, 360) / 30);
        $elements[$signElements[$sign]]++;
        $modes[$signModes[$sign]]++;
    }

    return ['elements' => $elements, 'modes' => $modes];
}
