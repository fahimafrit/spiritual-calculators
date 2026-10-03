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

final class DavisonInputError extends Exception
{
}

/** Reads and validates one person's birth data. */
function davison_parse_person(array $input, string $prefix, string $label, array &$warnings): array
{
    $name = trim((string) ($input[$prefix . '_name'] ?? ''));
    $name = $name === '' ? $label : mb_substr($name, 0, 60);

    $date = (string) ($input[$prefix . '_date'] ?? '');
    $time = (string) ($input[$prefix . '_time'] ?? '');

    if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $date, $d)) {
        throw new DavisonInputError($label . ': enter a birth date.');
    }
    if (!preg_match('/^(\d{2}):(\d{2})(?::(\d{2}))?$/', $time, $t)) {
        throw new DavisonInputError($label . ': enter a birth time.');
    }
    $hour = (int) $t[1];
    $minute = (int) $t[2];
    $second = (int) ($t[3] ?? 0);

    $latText = trim((string) ($input[$prefix . '_lat'] ?? ''));
    $lonText = trim((string) ($input[$prefix . '_lon'] ?? ''));
    $lat = is_numeric($latText) ? (float) $latText : NAN;
    $lon = is_numeric($lonText) ? (float) $lonText : NAN;
    if (is_nan($lat) || $lat < -90 || $lat > 90) {
        throw new DavisonInputError($label . ': latitude must be between -90 and 90.');
    }
    if (is_nan($lon) || $lon < -180 || $lon > 180) {
        throw new DavisonInputError($label . ': longitude must be between -180 and 180.');
    }

    $tz = trim((string) ($input[$prefix . '_tz'] ?? ''));
    if ($tz === '') {
        try {
            $tz = sc_tz_lookup($lat, $lon);
        } catch (Throwable $e) {
            throw new DavisonInputError($label . ': could not detect a time zone for these coordinates. Enter one (for example Asia/Dhaka).');
        }
    }

    try {
        if (!checkdate((int) $d[2], (int) $d[3], (int) $d[1]) || $hour > 23 || $minute > 59 || $second > 59) {
            throw new InvalidArgumentException('invalid date or time');
        }
        $zone = sc_tz_zone($tz);
        $local = new DateTimeImmutable(
            sprintf('%04d-%02d-%02d %02d:%02d:%02d', $d[1], $d[2], $d[3], $hour, $minute, $second),
            $zone
        );
    } catch (Throwable $e) {
        throw new DavisonInputError($label . ': the date, time or time zone "' . $tz . '" is not valid.');
    }

    if ((int) $local->format('G') !== $hour || (int) $local->format('i') !== $minute || (int) $local->format('j') !== (int) $d[3]) {
        $warnings[$prefix . '-gap'] = $label . ': ' . $date . ' ' . $time . ' does not exist in ' . $tz
            . ' (clocks skipped forward). It was read as ' . $local->format('H:i') . '.';
    }

    $utc = $local->setTimezone(new DateTimeZone('UTC'));
    $year = (int) $utc->format('Y');
    if ($year < 1800 || $year > 2399) {
        throw new DavisonInputError($label . ': dates must fall between 1800 and 2399.');
    }

    return [
        'name' => $name, 'lat' => $lat, 'lon' => $lon, 'tz' => $tz,
        'local' => $local, 'utc' => $utc,
        'jd' => 2440587.5 + $utc->getTimestamp() / 86400.0,
    ];
}

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

/** UTC date-time for a Julian day, seconds truncated (matches the page's format). */
function davison_jd_to_utc(float $jd): DateTimeImmutable
{
    $ms = (int) round(($jd - 2440587.5) * 86400000);
    return (new DateTimeImmutable('@' . (int) floor($ms / 1000)))->setTimezone(new DateTimeZone('UTC'));
}

return function (array $input): array {
    $warnings = [];

    try {
        $a = davison_parse_person($input, 'a', 'Person A', $warnings);
        $b = davison_parse_person($input, 'b', 'Person B', $warnings);
    } catch (DavisonInputError $e) {
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

    // The Davison method: midpoint in time (UT) and midpoint in space.
    $jdMid = ($a['jd'] + $b['jd']) / 2;
    $mid = davison_midpoint($a, $b, $method, $warnings);
    $chart = sc_swe_chart($jdMid, $mid['lat'], $mid['lon'], $opt, $warnings);

    $midUtc = davison_jd_to_utc($jdMid);
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
    ];
};
