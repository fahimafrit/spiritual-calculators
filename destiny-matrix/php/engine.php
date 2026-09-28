<?php
declare(strict_types=1);

/* ════════════════════════════════════════════════════════════════════
   DESTINY MATRIX — CALCULATION ENGINE (PHP)
   Server-side port of assets/js/destiny-matrix/calculations.js and of
   the validation / chakra-result logic that used to live inside
   destiny-matrix-calculator.html.

   Belongs to the Destiny Matrix category only. Every function here is
   prefixed dm_ so it can never clash with another category's engine.
   Never included directly from a browser request — each endpoint
   defines SPIRITUAL_APP before requiring it.
   ════════════════════════════════════════════════════════════════════ */

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

const DM_MONTH_NAMES = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

/* ── Core reduction ───────────────────────────────────────────────── */

/** Reduces a number by digit-summing until it is 22 or less. */
function dm_reduceNumber(int $number): int
{
    while ($number > 22) {
        $number = array_sum(array_map('intval', str_split((string) $number)));
    }
    return $number;
}

/** Digit sum of the year, then reduced. */
function dm_calculateYear(int $year): int
{
    $y = 0;
    while ($year > 0) {
        $y += $year % 10;
        $year = intdiv($year, 10);
    }
    return dm_reduceNumber($y);
}

/**
 * One "ring" of seven year points between two matrix points.
 * @return array<string,int>
 */
function dm_yearRing(int $x, int $y, string $prefix): array
{
    $base = dm_reduceNumber($x + $y);
    $n1 = dm_reduceNumber($x + $base);
    $n2 = dm_reduceNumber($x + $n1);
    $n3 = dm_reduceNumber($base + $n1);
    $n4 = dm_reduceNumber($base + $y);
    $n5 = dm_reduceNumber($base + $n4);
    $n6 = dm_reduceNumber($n4 + $y);

    return [
        $prefix . 'point' => $base,
        $prefix . '1point' => $n1,
        $prefix . '2point' => $n2,
        $prefix . '3point' => $n3,
        $prefix . '4point' => $n4,
        $prefix . '5point' => $n5,
        $prefix . '6point' => $n6,
    ];
}

/**
 * Computes every point of the chart from the three base points.
 * @return array{points:array<string,int>, purposes:array<string,int>, chartHeart:array<string,int>, years:array<string,int>}
 */
function dm_calculatePoints(int $a, int $b, int $c): array
{
    $red = 'dm_reduceNumber';

    $d = $red($a + $b + $c);
    $e = $red($a + $b + $c + $d);
    $f = $red($a + $b);
    $g = $red($b + $c);
    $h = $red($d + $a);
    $i = $red($c + $d);
    $j = $red($d + $e);

    $n = $red($c + $e);
    $l = $red($j + $n);
    $m = $red($l + $n);
    $k = $red($j + $l);

    $q = $red($n + $c);
    $r = $red($j + $d);
    $s = $red($a + $e);
    $t = $red($b + $e);

    $o = $red($a + $s);
    $p = $red($b + $t);

    $u = $red($f + $g + $h + $i);
    $v = $red($e + $u);
    $w = $red($s + $e);
    $x = $red($t + $e);

    $f2 = $red($f + $u);
    $f1 = $red($f + $f2);
    $g2 = $red($g + $u);
    $g1 = $red($g + $g2);
    $i2 = $red($i + $u);
    $i1 = $red($i + $i2);
    $h2 = $red($h + $u);
    $h1 = $red($h + $h2);

    $years = array_merge(
        dm_yearRing($a, $f, 'af'),
        dm_yearRing($f, $b, 'fb'),
        dm_yearRing($b, $g, 'bg'),
        dm_yearRing($g, $c, 'gc'),
        dm_yearRing($c, $i, 'ci'),
        dm_yearRing($i, $d, 'id'),
        dm_yearRing($d, $h, 'dh'),
        dm_yearRing($h, $a, 'ha')
    );

    $sky = $red($b + $d);
    $earth = $red($a + $c);
    $persPurpose = $red($sky + $earth);
    $female = $red($g + $h);
    $male = $red($f + $i);
    $socialPurpose = $red($female + $male);
    $generalPurpose = $red($persPurpose + $socialPurpose);
    $planetaryPurpose = $red($socialPurpose + $generalPurpose);

    $points = [
        'apoint' => $a, 'bpoint' => $b, 'cpoint' => $c,
        'dpoint' => $d, 'epoint' => $e, 'fpoint' => $f, 'gpoint' => $g,
        'hpoint' => $h, 'ipoint' => $i, 'jpoint' => $j,
        'kpoint' => $k, 'lpoint' => $l, 'mpoint' => $m, 'npoint' => $n,
        'opoint' => $o, 'ppoint' => $p, 'qpoint' => $q, 'rpoint' => $r,
        'spoint' => $s, 'tpoint' => $t, 'upoint' => $u, 'vpoint' => $v,
        'wpoint' => $w, 'xpoint' => $x,
        'f2point' => $f2, 'f1point' => $f1, 'g2point' => $g2, 'g1point' => $g1,
        'i2point' => $i2, 'i1point' => $i1, 'h2point' => $h2, 'h1point' => $h1,
    ];

    $purposes = [
        'skypoint' => $sky, 'earthpoint' => $earth, 'perspurpose' => $persPurpose,
        'femalepoint' => $female, 'malepoint' => $male, 'socialpurpose' => $socialPurpose,
        'generalpurpose' => $generalPurpose, 'planetarypurpose' => $planetaryPurpose,
    ];

    $chartHeart = [
        'sahphysics' => $a, 'ajphysics' => $o, 'vishphysics' => $s, 'anahphysics' => $w,
        'manphysics' => $e, 'svadphysics' => $n, 'mulphysics' => $c,

        'sahenergy' => $b, 'ajenergy' => $p, 'vishenergy' => $t, 'anahenergy' => $x,
        'manenergy' => $e, 'svadenergy' => $j, 'mulenergy' => $d,

        'sahemotions' => $red($a + $b),
        'ajemotions' => $red($o + $p),
        'vishemotions' => $red($s + $t),
        'anahemotions' => $red($w + $x),
        'manemotions' => $red($e + $e),
        'svademotions' => $red($j + $n),
        'mulemotions' => $red($c + $d),
    ];

    return ['points' => $points, 'purposes' => $purposes, 'chartHeart' => $chartHeart, 'years' => $years];
}

/** Base points -> full person array, from a parsed dd/mm/yyyy date. */
function dm_calculateFromDate(array $parsed): array
{
    $a = dm_reduceNumber($parsed['day']);
    $b = $parsed['month'];
    $c = dm_calculateYear($parsed['year']);
    return dm_calculatePoints($a, $b, $c);
}

/**
 * Flattens a person into one id => number map, exactly the set of
 * values the page writes into its elements: points, purposes, years,
 * every chakra-table cell, and the three chakra-table result cells.
 *
 * @return array<string,int>
 */
function dm_buildValues(array $person): array
{
    $values = array_merge(
        $person['points'],
        $person['chartHeart'],
        $person['purposes'],
        $person['years']
    );

    $rows = [
        'resultphysics' => ['sahphysics', 'ajphysics', 'vishphysics', 'anahphysics', 'manphysics', 'svadphysics', 'mulphysics'],
        'resultenergy' => ['sahenergy', 'ajenergy', 'vishenergy', 'anahenergy', 'manenergy', 'svadenergy', 'mulenergy'],
        'resultemotions' => ['sahemotions', 'ajemotions', 'vishemotions', 'anahemotions', 'manemotions', 'svademotions', 'mulemotions'],
    ];
    foreach ($rows as $resultId => $keys) {
        $sum = 0;
        foreach ($keys as $key) {
            $sum += $person['chartHeart'][$key];
        }
        $values[$resultId] = dm_reduceNumber($sum);
    }

    return $values;
}

/* ── Input handling (same rules the page applied client-side) ────── */

/** @return array{day:int, month:int, year:int}|null */
function dm_parseDate(string $value): ?array
{
    if (!preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/D', $value, $m)) {
        return null;
    }
    return ['day' => (int) $m[1], 'month' => (int) $m[2], 'year' => (int) $m[3]];
}

/** A real calendar date with a year of 100 or later. */
function dm_isValidDate(?array $parsed): bool
{
    if ($parsed === null || $parsed['year'] < 100) {
        return false;
    }
    return checkdate($parsed['month'], $parsed['day'], $parsed['year']);
}

function dm_isFutureDate(array $parsed): bool
{
    $candidate = DateTime::createFromFormat(
        '!Y-n-j',
        sprintf('%04d-%d-%d', $parsed['year'], $parsed['month'], $parsed['day'])
    );
    return $candidate > new DateTime('today');
}

function dm_formatLongDate(int $day, int $month, int $year): string
{
    return $day . ' ' . DM_MONTH_NAMES[$month - 1] . ' ' . $year;
}

/** Capitalizes the first letter and every letter after a space or dash. */
function dm_titleCase(string $str): string
{
    return preg_replace_callback(
        '/^[a-zа-яё]|[\- ][a-zа-яё]/u',
        static fn (array $m): string => function_exists('mb_strtoupper')
            ? mb_strtoupper($m[0], 'UTF-8')
            : strtoupper($m[0]),
        $str
    );
}

/**
 * Validates a submission. Pass $name = null when only the date matters.
 *
 * @return array{valid:bool, errorsHtml:string, parsed:?array}
 */
function dm_validateInput(string $dateRaw, ?string $name): array
{
    $parsed = dm_parseDate($dateRaw);
    $dateIsValid = dm_isValidDate($parsed);
    $errors = '';

    if (($name !== null && $name === '') || $parsed === null || !$dateIsValid) {
        $errors .= '<p>Date is not valid or one of the fields is empty. Use dd/mm/yyyy.</p>';
    }
    if ($parsed !== null && $dateIsValid && dm_isFutureDate($parsed)) {
        $errors .= "<p>Date can't be in the future.</p>";
    }
    if ($name !== null && !preg_match('/^[а-яё\- ]*[a-z\- ]*$/iuD', $name)) {
        $errors .= '<p>Name format is incorrect: allowed characters are letters, dash and space. Example: Anna, Anna-Maria, Anna Maria.</p>';
    }

    return [
        'valid' => $errors === '',
        'errorsHtml' => $errors,
        'parsed' => $parsed,
    ];
}