<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   SUN SIGN CALCULATOR — HANDLER
   Input (flat form fields):
     a_date                       yyyy-mm-dd   (required)
     a_time a_lat a_lon a_tz      HH:MM and the birth place (optional;
                                  a time needs a place, for its time zone)
   Output: { valid: true, exact, sign (0 = Aries ... 11 = Pisces), title,
             readingHtml, degree/minute (exact only),
             cusp: { from, to, at } (date-only births on a sign change) }

   With a birth time and place the Sun's position at that moment decides
   the sign. With only a date, the sign is certain unless the Sun changes
   sign somewhere on Earth during that calendar date; then the result says
   so and asks for the time and place.
   Called through the dispatcher: POST /calculate.php?slug=sun-sign-calculator
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/astrology/_shared/swetest.php';
require_once SPIRITUAL_ROOT . '/categories/astrology/_shared/timezone.php';
require_once SPIRITUAL_ROOT . '/categories/astrology/_shared/birth-data.php';

$sunSignReadings = require __DIR__ . '/readings.php';

function sun_sign_errors(array $messages): array
{
    $html = '';
    foreach ($messages as $message) {
        $html .= '<p>' . htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</p>';
    }
    return ['valid' => false, 'errorsHtml' => $html];
}

function sun_sign_reading_html(array $reading): string
{
    $html = '';
    foreach ($reading['sections'] as [$label, $text]) {
        $html .= '<div class="reading-block"><h3>' . htmlspecialchars($label, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
            . '</h3><p>' . htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</p></div>';
    }
    return $html;
}

/** Signed difference between two longitudes, in degrees, from -180 to 180. */
function sun_sign_diff(float $a, float $b): float
{
    return fmod(fmod($a - $b + 180.0, 360.0) + 360.0, 360.0) - 180.0;
}

/** Moment (jd, UT) the Sun reaches a sign boundary, searching from a start near it. */
function sun_sign_ingress_jd(float $boundary, float $startJd): float
{
    $jd = $startJd;
    for ($i = 0; $i < 5; $i++) {
        $jd -= sun_sign_diff(sc_swe_sun($jd), $boundary) / 0.9856;
    }
    return $jd;
}

return function (array $input) use ($sunSignReadings): array {
    $date = (string) ($input['a_date'] ?? '');
    if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/D', $date, $d) || !checkdate((int) $d[2], (int) $d[3], (int) $d[1])) {
        return sun_sign_errors(['Date is not valid or one of the fields is empty. Use dd/mm/yyyy.']);
    }
    [$year, $month, $day] = [(int) $d[1], (int) $d[2], (int) $d[3]];

    if ($date > (new DateTime('today'))->format('Y-m-d')) {
        return sun_sign_errors(["Date can't be in the future."]);
    }
    if ($year < 1800 || $year > 2399) {
        return sun_sign_errors(['Date must fall between 1800 and 2399.']);
    }

    $time = trim((string) ($input['a_time'] ?? ''));
    $latText = trim((string) ($input['a_lat'] ?? ''));
    $lonText = trim((string) ($input['a_lon'] ?? ''));
    $hasPlace = $latText !== '' || $lonText !== '';

    if ($hasPlace && ($latText === '' || $lonText === '')) {
        return sun_sign_errors(['Enter both latitude and longitude, or search for a birth place.']);
    }
    if ($time !== '' && !$hasPlace) {
        return sun_sign_errors(['Add a birth place to go with the birth time, or leave the time empty.']);
    }

    $result = ['valid' => true];

    if ($time !== '') {
        // Birth time and place: the Sun's position at that exact moment.
        $warnings = [];
        try {
            $person = sc_birth_parse_person($input, 'a', 'Birth', $warnings);
        } catch (SC_BirthDataError $e) {
            return sun_sign_errors([$e->getMessage()]);
        }
        $longitude = sc_swe_sun($person['jd']);
        $sign = (int) floor($longitude / 30.0);
        $inSign = $longitude - $sign * 30.0;
        $degree = (int) floor($inSign);

        $result += [
            'exact' => true,
            'degree' => $degree,
            'minute' => (int) floor(($inSign - $degree) * 60.0),
            'notices' => array_values($warnings),
        ];
    } else {
        // Date only. The calendar date lasts from 00:00 at UTC+14 to 24:00 at UTC-12.
        $midnightJd = 2440587.5 + gmmktime(0, 0, 0, $month, $day, $year) / 86400.0;
        $first = (int) floor(sc_swe_sun($midnightJd - 14 / 24) / 30.0);
        $last = (int) floor(sc_swe_sun($midnightJd + 1 + 12 / 24) / 30.0);

        $result['exact'] = false;
        if ($first === $last) {
            $sign = $first;
        } else {
            $sign = (int) floor(sc_swe_sun($midnightJd + 0.5) / 30.0);
            $ingress = sun_sign_ingress_jd((float) ($last * 30), $midnightJd + 0.5);
            $result['cusp'] = [
                'from' => $first,
                'to' => $last,
                'at' => gmdate('j F Y, H:i', (int) round(($ingress - 2440587.5) * 86400)) . ' UT',
            ];
        }
    }

    $reading = $sunSignReadings[$sign];
    $result['sign'] = $sign;
    $result['title'] = $reading['title'];
    $result['readingHtml'] = sun_sign_reading_html($reading);

    return $result;
};
