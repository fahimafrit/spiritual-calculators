<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   TIME ZONE FROM COORDINATES
   sc_tz_lookup(lat, lon) returns the IANA zone name for a point on
   Earth (for example "Asia/Tehran"). Used when a birth place has no
   time zone, and to show local time at the Davison midpoint.
   The lookup table lives in tz-data.php.
   ════════════════════════════════════════════════════════════════════ */

function sc_tz_lookup(float $lat, float $lon): string
{
    static $table = null;
    if ($table === null) {
        $table = require __DIR__ . '/tz-data.php';
    }
    $grid = $table['grid'];
    $zones = $table['zones'];
    $zoneCount = count($zones);

    if (!($lat >= -90.0 && $lat <= 90.0 && $lon >= -180.0 && $lon <= 180.0)) {
        throw new RangeException('invalid coordinates');
    }
    if ($lat >= 90.0) {
        return 'Etc/GMT';
    }

    $step = -1;
    $v = 48.0 * (180.0 + $lon) / 360.00000000000006;
    $x = 24.0 * (90.0 - $lat) / 180.00000000000003;
    $z = (int) $v;
    $m = (int) $x;
    $g = 96 * $m + 2 * $z;
    $g = 56 * ord($grid[$g]) + ord($grid[$g + 1]) - 1995;

    while ($g + $zoneCount < 3136) {
        $step = $step + $g + 1;
        $x = fmod(2.0 * ($x - $m), 2.0);
        $m = (int) $x;
        $v = fmod(2.0 * ($v - $z), 2.0);
        $z = (int) $v;
        $g = 8 * $step + 4 * $m + 2 * $z + 2304;
        $g = 56 * ord($grid[$g]) + ord($grid[$g + 1]) - 1995;
    }

    return $zones[$g + $zoneCount - 3136];
}

/**
 * A DateTimeZone for a zone name, accepting the older names that the
 * coordinate lookup can return but some PHP time zone databases dropped.
 */
function sc_tz_zone(string $name): DateTimeZone
{
    static $renamed = [
        'America/Godthab' => 'America/Nuuk',
        'Europe/Kiev' => 'Europe/Kyiv',
        'Europe/Uzhgorod' => 'Europe/Kyiv',
        'Europe/Zaporozhye' => 'Europe/Kyiv',
        'Pacific/Enderbury' => 'Pacific/Kanton',
    ];

    try {
        return new DateTimeZone($name);
    } catch (Exception $e) {
        if (isset($renamed[$name])) {
            return new DateTimeZone($renamed[$name]);
        }
        throw $e;
    }
}
