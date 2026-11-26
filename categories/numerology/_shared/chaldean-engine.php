<?php
declare(strict_types=1);

/* ════════════════════════════════════════════════════════════════════
   NUMEROLOGY CORE — CHALDEAN NAME MATH (PHP)
   The Chaldean letter system, kept apart from the Pythagorean engine
   (engine.php). Letters carry values 1-8; the number 9 is never given
   to a letter. A name's total is its Compound Number; the Compound
   Number reduces fully to a single digit (1-9) — Chaldean numerology
   has no master numbers. Never included directly from a browser
   request.
   ════════════════════════════════════════════════════════════════════ */

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/engine.php';

/** @return array<string,int> */
function getChaldeanLetterValues(): array
{
    static $values = null;
    if ($values === null) {
        $values = buildLetterMap([
            1 => 'aijqy', 2 => 'bkr', 3 => 'cgls', 4 => 'dmt',
            5 => 'ehnx', 6 => 'uvw', 7 => 'oz', 8 => 'fp',
        ]);
    }
    return $values;
}

/**
 * Chaldean reading of a name. $filter narrows to 'vowels' or
 * 'consonants' — omit (null) to count every letter.
 *
 * @return array{
 *   total:int,
 *   breakdown:array<int,array{letter:string,value:int}>,
 *   words:array<int,array{word:string,breakdown:array<int,array{letter:string,value:int}>,total:int}>,
 *   steps:int[],
 *   number:int
 * }
 */
function computeChaldeanName(string $name, ?string $filter = null): array
{
    $values = getChaldeanLetterValues();
    $parts = preg_split('/[\s\-]+/', strtolower($name), -1, PREG_SPLIT_NO_EMPTY) ?: [];

    $words = [];
    $breakdown = [];
    $total = 0;

    foreach ($parts as $part) {
        $wordBreakdown = [];
        $wordTotal = 0;

        foreach (str_split($part) as $letter) {
            if (!ctype_lower($letter)) {
                continue;
            }
            $isVowel = in_array($letter, VOWELS, true);
            if (($filter === 'vowels' && !$isVowel) || ($filter === 'consonants' && $isVowel)) {
                continue;
            }
            $value = $values[$letter] ?? 0;
            $wordBreakdown[] = ['letter' => $letter, 'value' => $value];
            $wordTotal += $value;
        }

        if ($wordBreakdown === []) {
            continue;
        }

        $letters = implode('', array_column($wordBreakdown, 'letter'));
        $words[] = ['word' => strtoupper($letters), 'breakdown' => $wordBreakdown, 'total' => $wordTotal];
        $breakdown = array_merge($breakdown, $wordBreakdown);
        $total += $wordTotal;
    }

    $steps = reduceToSingleDigitWithSteps($total);

    return [
        'total' => $total,
        'breakdown' => $breakdown,
        'words' => $words,
        'steps' => $steps,
        'number' => (int) end($steps),
    ];
}

/**
 * Standard Chaldean notation: "30/3" for a compound total, plain "5"
 * when the total is already a single digit.
 */
function formatChaldeanNumber(int $total, int $reduced): string
{
    return $total > 9 ? $total . '/' . $reduced : (string) $reduced;
}
