<?php
declare(strict_types=1);

/* ════════════════════════════════════════════════════════════════════
   COMPATIBILITY MATRIX — CALCULATION ENGINE (PHP)
   Server-side port of the calculateCompatibility logic and of the
   two-date validation that used to live inside
   compatibility-matrix-calculator.html.

   Belongs to the Destiny Matrix category. It builds on the shared
   Destiny Matrix engine (php/engine.php) for point reduction, the
   personal-chart calculation and date handling. Every function here
   is prefixed cm_ so it can never clash with another engine.
   Never included directly from a browser request — the endpoint
   defines SPIRITUAL_APP before requiring it.
   ════════════════════════════════════════════════════════════════════ */

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

require_once __DIR__ . '/engine.php';

/**
 * Compatibility points a–i: reduced sum of the same-position point from
 * each personal matrix. j–t and the purposes are derived from the
 * compatibility matrix's own a–i, never pulled from either personal
 * matrix directly.
 *
 * @param array<string,int> $person1Points
 * @param array<string,int> $person2Points
 * @return array{points:array<string,int>, purposes:array<string,int>}
 */
function cm_calculateCompatibility(array $person1Points, array $person2Points): array
{
    $red = 'dm_reduceNumber';

    $a = $red($person1Points['apoint'] + $person2Points['apoint']);
    $b = $red($person1Points['bpoint'] + $person2Points['bpoint']);
    $c = $red($person1Points['cpoint'] + $person2Points['cpoint']);
    $d = $red($person1Points['dpoint'] + $person2Points['dpoint']);
    $e = $red($person1Points['epoint'] + $person2Points['epoint']);
    $f = $red($person1Points['fpoint'] + $person2Points['fpoint']);
    $g = $red($person1Points['gpoint'] + $person2Points['gpoint']);
    $h = $red($person1Points['hpoint'] + $person2Points['hpoint']);
    $i = $red($person1Points['ipoint'] + $person2Points['ipoint']);

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

    $points = [
        'apoint' => $a, 'bpoint' => $b, 'cpoint' => $c, 'dpoint' => $d, 'epoint' => $e,
        'fpoint' => $f, 'gpoint' => $g, 'hpoint' => $h, 'ipoint' => $i,
        'jpoint' => $j, 'kpoint' => $k, 'lpoint' => $l, 'mpoint' => $m, 'npoint' => $n,
        'opoint' => $o, 'ppoint' => $p, 'qpoint' => $q, 'rpoint' => $r,
        'spoint' => $s, 'tpoint' => $t,
    ];

    $sky = $red($b + $d);
    $earth = $red($a + $c);
    $persPurpose = $red($sky + $earth);
    $female = $red($g + $h);
    $male = $red($f + $i);
    $socialPurpose = $red($female + $male);
    $generalPurpose = $red($persPurpose + $socialPurpose);
    $planetaryPurpose = $red($socialPurpose + $generalPurpose);

    $purposes = [
        'skypoint' => $sky, 'earthpoint' => $earth, 'perspurpose' => $persPurpose,
        'femalepoint' => $female, 'malepoint' => $male, 'socialpurpose' => $socialPurpose,
        'generalpurpose' => $generalPurpose, 'planetarypurpose' => $planetaryPurpose,
    ];

    return ['points' => $points, 'purposes' => $purposes];
}

/**
 * Validates both partner dates.
 *
 * @return array{valid:bool, errorsHtml:string, parsed1:?array, parsed2:?array}
 */
function cm_validateInput(string $date1Raw, string $date2Raw): array
{
    $errors = '';
    $parsedList = [];

    foreach ([['Partner 1', $date1Raw], ['Partner 2', $date2Raw]] as [$label, $raw]) {
        $parsed = dm_parseDate($raw);
        if ($parsed === null || !dm_isValidDate($parsed)) {
            $errors .= '<p>' . $label . ' date is not valid or empty. Use DD/MM/YYYY.</p>';
        } elseif (dm_isFutureDate($parsed)) {
            $errors .= '<p>' . $label . " date can't be in the future.</p>";
        }
        $parsedList[] = $parsed;
    }

    return [
        'valid' => $errors === '',
        'errorsHtml' => $errors,
        'parsed1' => $parsedList[0],
        'parsed2' => $parsedList[1],
    ];
}

/**
 * Builds everything the page needs: the header HTML and one id => number
 * map for each of the three tabs (compatibility, Partner 1, Partner 2).
 *
 * @return array{headerHtml:string, compat:array<string,int>, p1:array<string,int>, p2:array<string,int>}
 */
function cm_buildResult(array $parsed1, array $parsed2): array
{
    $person1 = dm_calculateFromDate($parsed1);
    $person2 = dm_calculateFromDate($parsed2);
    $compat = cm_calculateCompatibility($person1['points'], $person2['points']);

    $fullDate1 = dm_formatLongDate($parsed1['day'], $parsed1['month'], $parsed1['year']);
    $fullDate2 = dm_formatLongDate($parsed2['day'], $parsed2['month'], $parsed2['year']);

    return [
        'headerHtml' => 'Compatibility Matrix <span class="gray">Partner 1: ' . $fullDate1
            . ' — Partner 2: ' . $fullDate2 . '</span>',
        'compat' => array_merge($compat['points'], $compat['purposes']),
        'p1' => array_merge($person1['points'], $person1['purposes'], $person1['years']),
        'p2' => array_merge($person2['points'], $person2['purposes'], $person2['years']),
    ];
}