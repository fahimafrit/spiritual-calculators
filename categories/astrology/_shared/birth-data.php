<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   ASTROLOGY CORE — BIRTH DATA PARSING (PHP)
   Shared by every astrology calculator that reads a person's birth
   data from flat form fields. Pure functions only — no output, no
   HTTP, no HTML, no interpretation text.
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/astrology/_shared/timezone.php';

final class SC_BirthDataError extends Exception
{
}

/** Reads and validates one person's birth data. */
function sc_birth_parse_person(array $input, string $prefix, string $label, array &$warnings): array
{
    $name = trim((string) ($input[$prefix . '_name'] ?? ''));
    $name = $name === '' ? $label : mb_substr($name, 0, 60);

    $date = (string) ($input[$prefix . '_date'] ?? '');
    $time = (string) ($input[$prefix . '_time'] ?? '');

    if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $date, $d)) {
        throw new SC_BirthDataError($label . ': enter a birth date.');
    }
    if (!preg_match('/^(\d{2}):(\d{2})(?::(\d{2}))?$/', $time, $t)) {
        throw new SC_BirthDataError($label . ': enter a birth time.');
    }
    $hour = (int) $t[1];
    $minute = (int) $t[2];
    $second = (int) ($t[3] ?? 0);

    $latText = trim((string) ($input[$prefix . '_lat'] ?? ''));
    $lonText = trim((string) ($input[$prefix . '_lon'] ?? ''));
    $lat = is_numeric($latText) ? (float) $latText : NAN;
    $lon = is_numeric($lonText) ? (float) $lonText : NAN;
    if (is_nan($lat) || $lat < -90 || $lat > 90) {
        throw new SC_BirthDataError($label . ': latitude must be between -90 and 90.');
    }
    if (is_nan($lon) || $lon < -180 || $lon > 180) {
        throw new SC_BirthDataError($label . ': longitude must be between -180 and 180.');
    }

    $tz = trim((string) ($input[$prefix . '_tz'] ?? ''));
    if ($tz === '') {
        try {
            $tz = sc_tz_lookup($lat, $lon);
        } catch (Throwable $e) {
            throw new SC_BirthDataError($label . ': could not detect a time zone for these coordinates. Enter one (for example Asia/Dhaka).');
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
        throw new SC_BirthDataError($label . ': the date, time or time zone "' . $tz . '" is not valid.');
    }

    if ((int) $local->format('G') !== $hour || (int) $local->format('i') !== $minute || (int) $local->format('j') !== (int) $d[3]) {
        $warnings[$prefix . '-gap'] = $label . ': ' . $date . ' ' . $time . ' does not exist in ' . $tz
            . ' (clocks skipped forward). It was read as ' . $local->format('H:i') . '.';
    }

    $utc = $local->setTimezone(new DateTimeZone('UTC'));
    $year = (int) $utc->format('Y');
    if ($year < 1800 || $year > 2399) {
        throw new SC_BirthDataError($label . ': dates must fall between 1800 and 2399.');
    }

    return [
        'name' => $name, 'lat' => $lat, 'lon' => $lon, 'tz' => $tz,
        'local' => $local, 'utc' => $utc,
        'jd' => 2440587.5 + $utc->getTimestamp() / 86400.0,
    ];
}

/** UTC date-time for a Julian day, seconds truncated (matches the page's format). */
function sc_jd_to_utc(float $jd): DateTimeImmutable
{
    $ms = (int) round(($jd - 2440587.5) * 86400000);
    return (new DateTimeImmutable('@' . (int) floor($ms / 1000)))->setTimezone(new DateTimeZone('UTC'));
}
