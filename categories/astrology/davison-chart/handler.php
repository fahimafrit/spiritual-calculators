<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   DAVISON RELATIONSHIP CHART — HANDLER
   Input (flat form fields, A and B are the two people):
     a_name a_date a_time a_lat a_lon a_tz     (date yyyy-mm-dd, time HH:MM)
     b_name b_date b_time b_lat b_lon b_tz
     house zodiac node midpoint                (all optional)
   Output: { valid: true, meta, persons, davison, chart }
   Called through the dispatcher: POST /calculate.php?slug=davison-chart
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/astrology/_shared/swetest.php';
require_once SPIRITUAL_ROOT . '/categories/astrology/_shared/timezone.php';
require_once SPIRITUAL_ROOT . '/categories/astrology/_shared/aspects.php';
require_once SPIRITUAL_ROOT . '/categories/astrology/_shared/birth-data.php';

/** Midpoint of two places: arithmetic (shortest arc) or great-circle. */
function davison_midpoint(array $a, array $b, string $method, array &$warnings): array
{
    if ($method === 'greatcircle') {
        $vector = static fn(array $p): array => [
            cos(deg2rad($p['lat'])) * cos(deg2rad($p['lon'])),
            cos(deg2rad($p['lat'])) * sin(deg2rad($p['lon'])),
            sin(deg2rad($p['lat'])),
        ];
        $va = $vector($a);
        $vb = $vector($b);
        $s = [$va[0] + $vb[0], $va[1] + $vb[1], $va[2] + $vb[2]];
        $len = sqrt($s[0] ** 2 + $s[1] ** 2 + $s[2] ** 2);
        if ($len > 1e-9) {
            return ['lat' => rad2deg(asin($s[2] / $len)), 'lon' => rad2deg(atan2($s[1], $s[0]))];
        }
        $warnings['midpoint-opposite'] = 'The two birthplaces are almost exactly opposite each other, so a great-circle midpoint is undefined. The arithmetic midpoint was used.';
    }

    $lat = ($a['lat'] + $b['lat']) / 2;
    $diff = fmod(fmod($b['lon'] - $a['lon'] + 540, 360) + 360, 360) - 180;
    $lon = fmod(fmod($a['lon'] + $diff / 2 + 540, 360) + 360, 360) - 180;

    return ['lat' => $lat, 'lon' => $lon];
}

return function (array $input): array {
    $warnings = [];

    try {
        $a = sc_birth_parse_person($input, 'a', 'Person A', $warnings);
        $b = sc_birth_parse_person($input, 'b', 'Person B', $warnings);
    } catch (SC_BirthDataError $e) {
        return ['valid' => false, 'errorsHtml' => '<p>' . htmlspecialchars($e->getMessage(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</p>'];
    }

    $houseKey = (string) ($input['house'] ?? 'P');
    $hsys = isset(SC_SWE_HOUSE_SYSTEMS[$houseKey]) ? $houseKey : 'P';
    $zodiacKey = (string) ($input['zodiac'] ?? 'tropical');
    $sidereal = isset(SC_SWE_AYANAMSAS[$zodiacKey]) ? $zodiacKey : '';
    $opt = [
        'hsys' => $hsys,
        'node' => ($input['node'] ?? 'true') === 'mean' ? 'mean' : 'true',
        'sidereal' => $sidereal,
    ];
    $method = ($input['midpoint'] ?? 'arithmetic') === 'greatcircle' ? 'greatcircle' : 'arithmetic';
    $aspectsMode = ($input['aspects'] ?? 'major') === 'all' ? 'all' : 'major';

    // The Davison method: midpoint in time (UT) and midpoint in space.
    $jdMid = ($a['jd'] + $b['jd']) / 2;
    $mid = davison_midpoint($a, $b, $method, $warnings);
    $chart = sc_swe_chart($jdMid, $mid['lat'], $mid['lon'], $opt, $warnings);

    $midUtc = sc_jd_to_utc($jdMid);
    try {
        $midTz = sc_tz_lookup($mid['lat'], $mid['lon']);
    } catch (Throwable $e) {
        $midTz = 'UTC';
    }
    $midLocal = $midUtc->setTimezone(sc_tz_zone($midTz));

    // Notices come from the Davison chart only, so the people's own charts use a throwaway list.
    $summary = function (array $p) use ($opt): array {
        $ignored = [];
        $c = sc_swe_chart($p['jd'], $p['lat'], $p['lon'], $opt, $ignored, false);
        $pick = static function (string $key) use ($c): ?float {
            foreach ($c['bodies'] as $body) {
                if ($body['key'] === $key) {
                    return $body['lon'];
                }
            }
            return null;
        };
        return [
            'name' => $p['name'], 'tz' => $p['tz'], 'lat' => $p['lat'], 'lon' => $p['lon'],
            'local' => $p['local']->format('Y-m-d H:i'),
            'offset' => $p['local']->format('P'),
            'utc' => $p['utc']->format('Y-m-d H:i:s'),
            'sun' => $pick('sun'), 'moon' => $pick('moon'), 'asc' => $c['asc'],
        ];
    };
    $persons = [$summary($a), $summary($b)];

    return [
        'valid' => true,
        'meta' => [
            'houseSystemUsed' => SC_SWE_HOUSE_SYSTEMS[$chart['hsysUsed']],
            'zodiac' => $sidereal !== '' ? 'Sidereal (' . SC_SWE_AYANAMSAS[$sidereal]['name'] . ')' : 'Tropical',
            'ayanamsa' => $sidereal !== '' ? sc_swe_ayanamsa($jdMid, $sidereal) : null,
            'warnings' => array_values($warnings),
        ],
        'persons' => $persons,
        'davison' => [
            'jd' => $jdMid,
            'utc' => $midUtc->format('Y-m-d H:i:s'),
            'local' => $midLocal->format('Y-m-d H:i:s'),
            'tz' => $midTz,
            'offset' => $midLocal->format('P'),
            'lat' => $mid['lat'],
            'lon' => $mid['lon'],
        ],
        'chart' => [
            'bodies' => $chart['bodies'],
            'cusps' => $chart['cusps'],
            'asc' => $chart['asc'],
            'mc' => $chart['mc'],
            'vertex' => $chart['vertex'],
        ],
        'aspects' => sc_compute_aspects($chart, $aspectsMode === 'all'),
        'balance' => sc_element_mode_balance($chart),
    ];
};
