<?php
declare(strict_types=1);

/* ════════════════════════════════════════════════════════════════════
   NUMEROLOGY CORE — CALCULATION ENGINE (PHP)
   Server-side port of assets/js/numerology/calculations.js.
   Shared by every calculator under /numerology/api/ — this file owns
   ONLY the math: reduction rules, master-number handling, and
   letter-value systems. Never included directly from a browser
   request — each endpoint defines SPIRITUAL_APP before requiring it.
   ════════════════════════════════════════════════════════════════════ */

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

const MASTER_NUMBERS = [11, 22, 33];

function isMasterNumber(int $number): bool
{
    return in_array($number, MASTER_NUMBERS, true);
}

/**
 * Sums the digits of a number once (no reduction loop).
 * e.g. 1988 -> 1+9+8+8 -> 26
 */
function sumDigitsOnce(int $number): int
{
    $sum = 0;
    foreach (str_split((string) abs($number)) as $digit) {
        $sum += (int) $digit;
    }
    return $sum;
}

/**
 * Reduces a number down to a single digit (1-9) or a master number
 * (11, 22, 33), and returns every intermediate value along the way —
 * including the starting number itself.
 *
 * A master number is never reduced further, wherever it appears in
 * the chain: reduceKeepingMasterWithSteps(1994) -> [1994, 23, 5]
 * reduceKeepingMasterWithSteps(29)   -> [29, 11]        (stops at 11)
 * reduceKeepingMasterWithSteps(7)    -> [7]              (already done)
 *
 * @return int[]
 */
function reduceKeepingMasterWithSteps(int $number): array
{
    $steps = [$number];
    $value = $number;
    while ($value > 9 && !isMasterNumber($value)) {
        $value = sumDigitsOnce($value);
        $steps[] = $value;
    }
    return $steps;
}

/**
 * Reduces a master number down to its underlying single digit
 * (11 -> 2, 22 -> 4, 33 -> 6). Used only as a fallback lookup key for
 * interpretation content that hasn't been written for the master
 * number itself yet — never used to change the displayed result.
 */
function reduceToSingleDigit(int $number): int
{
    $value = $number;
    while ($value > 9) {
        $value = sumDigitsOnce($value);
    }
    return $value;
}

/**
 * Formats a number for display using the site's standard dual format
 * for master numbers — 11 -> "11/2", 22 -> "22/4", 33 -> "33/6" — and
 * plain digits otherwise.
 */
function formatDisplayNumber(int $number): string
{
    return isMasterNumber($number)
        ? $number . '/' . reduceToSingleDigit($number)
        : (string) $number;
}

/* ── Letter values (Destiny Number, Soul Urge, etc) ───────────────── */

/** @return array<string,int> */
function buildLetterMap(array $groups): array
{
    $map = [];
    foreach ($groups as $value => $letters) {
        foreach (str_split($letters) as $letter) {
            $map[$letter] = (int) $value;
        }
    }
    return $map;
}

function getLetterValues(): array
{
    static $letterValues = null;
    if ($letterValues === null) {
        $letterValues = buildLetterMap([
            1 => 'ajs', 2 => 'bkt', 3 => 'clu', 4 => 'dmv', 5 => 'enw',
            6 => 'fox', 7 => 'gpy', 8 => 'hqz', 9 => 'ir',
        ]);
    }
    return $letterValues;
}

const VOWELS = ['a', 'e', 'i', 'o', 'u'];

/**
 * Computes a name's numerology total. $filter optionally narrows to
 * 'vowels' or 'consonants' — omit (null) to use every letter, as
 * Destiny Number does.
 *
 * @return array{total:int, breakdown: array<int, array{letter:string, value:int}>}
 */
function computeNameNumber(string $name, ?string $filter = null): array
{
    $letterValues = getLetterValues();
    $letters = array_filter(str_split(strtolower($name)), fn ($ch) => ctype_lower($ch));

    $counted = array_filter($letters, function ($letter) use ($filter) {
        if ($filter === 'vowels') return in_array($letter, VOWELS, true);
        if ($filter === 'consonants') return !in_array($letter, VOWELS, true);
        return true;
    });

    $breakdown = [];
    $total = 0;
    foreach ($counted as $letter) {
        $value = $letterValues[$letter] ?? 0;
        $breakdown[] = ['letter' => $letter, 'value' => $value];
        $total += $value;
    }
    return ['total' => $total, 'breakdown' => $breakdown];
}

/**
 * Full reduction of a name: total, per-letter breakdown, and every
 * reduction step (masters kept). $filter is the same as
 * computeNameNumber() — null for every letter (Destiny Number),
 * 'vowels' for Soul Urge, 'consonants' for Personality.
 *
 * @return array{total:int, breakdown:array<int,array{letter:string,value:int}>, steps:int[], number:int}
 */
function computeNameReduction(string $name, ?string $filter = null): array
{
    ['total' => $total, 'breakdown' => $breakdown] = computeNameNumber($name, $filter);
    $steps = reduceKeepingMasterWithSteps($total);
    return [
        'total' => $total,
        'breakdown' => $breakdown,
        'steps' => $steps,
        'number' => end($steps),
    ];
}

/**
 * How many times each number 1-9 appears in a name's letter values.
 * Numbers that never appear have a count of 0.
 *
 * @param array<int,array{letter:string,value:int}> $breakdown  from computeNameNumber()
 * @return array<int,int>
 */
function countNumberFrequencies(array $breakdown): array
{
    $counts = array_fill(1, 9, 0);
    foreach ($breakdown as $entry) {
        if (isset($counts[$entry['value']])) {
            $counts[$entry['value']]++;
        }
    }
    return $counts;
}

/**
 * Life Path from a birth date: day, month and year are each reduced
 * (masters kept), summed, and the sum is reduced again.
 *
 * @return array{daySteps:int[], monthSteps:int[], yearSteps:int[],
 *               dayFinal:int, monthFinal:int, yearFinal:int,
 *               total:int, totalSteps:int[], number:int}
 */
function computeLifePath(int $day, int $month, int $year): array
{
    $daySteps = reduceKeepingMasterWithSteps($day);
    $monthSteps = reduceKeepingMasterWithSteps($month);
    $yearSteps = reduceKeepingMasterWithSteps($year);

    $dayFinal = end($daySteps);
    $monthFinal = end($monthSteps);
    $yearFinal = end($yearSteps);

    $total = $dayFinal + $monthFinal + $yearFinal;
    $totalSteps = reduceKeepingMasterWithSteps($total);

    return [
        'daySteps' => $daySteps,
        'monthSteps' => $monthSteps,
        'yearSteps' => $yearSteps,
        'dayFinal' => $dayFinal,
        'monthFinal' => $monthFinal,
        'yearFinal' => $yearFinal,
        'total' => $total,
        'totalSteps' => $totalSteps,
        'number' => end($totalSteps),
    ];
}

/* ── Karmic debt ──────────────────────────────────────────────────── */

const KARMIC_DEBT_NUMBERS = [13, 14, 16, 19];

function isKarmicDebtNumber(int $number): bool
{
    return in_array($number, KARMIC_DEBT_NUMBERS, true);
}

/**
 * Which karmic debt numbers (13, 14, 16, 19) appear anywhere in a
 * reduction chain, in ascending order.
 *
 * @param int[] $steps
 * @return int[]
 */
function findKarmicDebtInSteps(array $steps): array
{
    return array_values(array_filter(
        KARMIC_DEBT_NUMBERS,
        fn ($debt) => in_array($debt, $steps, true)
    ));
}

/* ── Date helpers (shared by every date-based calculator) ────────── */

/** @return array{day:int, month:int, year:int}|null */
function parseDdMmYyyy(string $value): ?array
{
    if (!preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/D', $value, $m)) {
        return null;
    }
    return ['day' => (int) $m[1], 'month' => (int) $m[2], 'year' => (int) $m[3]];
}

function isValidCalendarDate(?array $parsed): bool
{
    if ($parsed === null || $parsed['year'] < 100) return false;
    return checkdate($parsed['month'], $parsed['day'], $parsed['year']);
}

function isDateInFuture(array $parsed): bool
{
    $candidate = DateTime::createFromFormat(
        '!Y-n-j',
        sprintf('%04d-%d-%d', $parsed['year'], $parsed['month'], $parsed['day'])
    );
    $today = new DateTime('today');
    return $candidate > $today;
}

/**
 * Validates a submitted birth date exactly as every date-based
 * calculator does: dd/mm/yyyy, a real calendar date, not in the future.
 *
 * @return array{errors:string[], parsed:?array{day:int,month:int,year:int}}
 */
function validateBirthDate(string $raw): array
{
    $parsed = parseDdMmYyyy($raw);

    if (!isValidCalendarDate($parsed)) {
        return ['errors' => ['Date is not valid. Use dd/mm/yyyy.'], 'parsed' => null];
    }
    if (isDateInFuture($parsed)) {
        return ['errors' => ["Date can't be in the future."], 'parsed' => null];
    }
    return ['errors' => [], 'parsed' => $parsed];
}

const MONTH_NAMES = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

function formatLongDate(int $day, int $month, int $year): string
{
    return $day . ' ' . MONTH_NAMES[$month - 1] . ' ' . $year;
}

/* ── Name helpers (shared by every name-based calculator) ────────── */

/**
 * Capitalizes the first letter of the string and the first letter
 * after every space or dash. Matches the JS titleCase() character
 * class exactly (Latin + Cyrillic), including its quirks.
 */
function titleCase(string $str): string
{
    return preg_replace_callback(
        '/^[a-zа-яё]|[\- ][a-zа-яё]/iu',
        fn ($m) => mb_strtoupper($m[0], 'UTF-8'),
        $str
    );
}

/**
 * Validates a submitted name exactly as the client-side validate()
 * function did: must contain at least one ASCII letter, and may only
 * contain letters (Latin or Cyrillic), spaces, and dashes.
 *
 * @return array{valid:bool, errorHtml:string}
 */
function validateName(string $name): array
{
    if (trim(preg_replace('/[^a-zA-Z]/', '', $name)) === '') {
        return [
            'valid' => false,
            'errorHtml' => '<p>Enter a name using letters only (spaces and dashes are fine).</p>',
        ];
    }
    if (!preg_match('/^[a-zа-яё\- ]*$/iu', $name)) {
        return [
            'valid' => false,
            'errorHtml' => '<p>Name format is incorrect: allowed characters are letters, dash and space. Example: John Michael Smith.</p>',
        ];
    }
    return ['valid' => true, 'errorHtml' => ''];
}