<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   BIRTH CHART (NATAL CHART) — HANDLER
   Input (flat form fields, one person):
     a_name a_date a_time a_lat a_lon a_tz     (date yyyy-mm-dd, time HH:MM)
     house zodiac node aspects                 (all optional)
   Output: { valid: true, meta, person, chart, aspects, balance }
   Called through the dispatcher: POST /calculate.php?slug=birth-chart
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/astrology/_shared/swetest.php';
require_once SPIRITUAL_ROOT . '/categories/astrology/_shared/timezone.php';
require_once SPIRITUAL_ROOT . '/categories/astrology/_shared/aspects.php';
require_once SPIRITUAL_ROOT . '/categories/astrology/_shared/birth-data.php';

return function (array $input): array {
    $warnings = [];

    try {
        $person = sc_birth_parse_person($input, 'a', 'Birth chart', $warnings);
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
    $aspectsMode = ($input['aspects'] ?? 'major') === 'all' ? 'all' : 'major';

    $chart = sc_swe_chart($person['jd'], $person['lat'], $person['lon'], $opt, $warnings);

    return [
        'valid' => true,
        'meta' => [
            'houseSystemUsed' => SC_SWE_HOUSE_SYSTEMS[$chart['hsysUsed']],
            'zodiac' => $sidereal !== '' ? 'Sidereal (' . SC_SWE_AYANAMSAS[$sidereal]['name'] . ')' : 'Tropical',
            'ayanamsa' => $sidereal !== '' ? sc_swe_ayanamsa($person['jd'], $sidereal) : null,
            'warnings' => array_values($warnings),
        ],
        'person' => [
            'name' => $person['name'],
            'tz' => $person['tz'],
            'lat' => $person['lat'],
            'lon' => $person['lon'],
            'local' => $person['local']->format('Y-m-d H:i'),
            'offset' => $person['local']->format('P'),
            'utc' => $person['utc']->format('Y-m-d H:i:s'),
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
