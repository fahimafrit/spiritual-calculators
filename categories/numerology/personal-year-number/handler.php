<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   PERSONAL YEAR NUMBER — HANDLER
   Input:  { date: "dd/mm/yyyy", year: "yyyy" }
   Uses the birth day and month plus the chosen calendar year (the
   current year when no year is sent; the birth year is not used). The
   result is always a single digit 1-9: no master numbers are kept at
   any step. Besides the number, the result lists the position in the
   nine-year cycle, the previous and next year, and the Personal Month
   number for each month of the chosen year (Personal Year + calendar
   month, reduced to one digit). Output: the rendered result fragments
   only — never the reduction engine or the interpretation library
   itself.
   Called through the dispatcher: POST /calculate.php?slug=personal-year-number
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/engine.php';
require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/render.php';

$personalYearData = require __DIR__ . '/readings.php';

return function (array $input) use ($personalYearData): array {
    ['errors' => $errors, 'parsed' => $parsed] = validateBirthDate((string) ($input['date'] ?? ''));

    if (!empty($errors)) {
        return ['valid' => false, 'errorsHtml' => renderErrors($errors)];
    }

    ['day' => $day, 'month' => $month, 'year' => $year] = $parsed;

    if (!isset($input['year'])) {
        $targetYear = (int) (new DateTime('today'))->format('Y');
    } else {
        $rawYear = trim((string) $input['year']);
        if (!preg_match('/^\d{4}$/D', $rawYear) || (int) $rawYear < 1900 || (int) $rawYear > 2100) {
            return ['valid' => false, 'errorsHtml' => renderErrors(['Enter a year between 1900 and 2100.'])];
        }
        $targetYear = (int) $rawYear;
    }

    $daySteps = reduceToSingleDigitWithSteps($day);
    $monthSteps = reduceToSingleDigitWithSteps($month);
    $yearSteps = reduceToSingleDigitWithSteps($targetYear);

    $dayFinal = end($daySteps);
    $monthFinal = end($monthSteps);
    $yearFinal = end($yearSteps);

    $total = $dayFinal + $monthFinal + $yearFinal;
    $totalSteps = reduceToSingleDigitWithSteps($total);
    $personalYear = end($totalSteps);
    $numDisplay = (string) $personalYear;

    $lines = [
        renderProcessLine('Birth Day', $day, $daySteps),
        renderProcessLine('Birth Month', $month, $monthSteps),
        renderProcessLine('Year', $targetYear, $yearSteps),
        renderSumLine('Sum', [$dayFinal, $monthFinal, $yearFinal], $total, $totalSteps),
        renderFinalLine('Personal Year Number for ' . $targetYear . ': ' . $numDisplay),
    ];

    /* Personal Year of any year, from the same birth day and month. */
    $yearNumber = static fn (int $y): int => reduceToSingleDigit($dayFinal + $monthFinal + reduceToSingleDigit($y));

    $glance = [
        renderValueLine('Cycle position', 'Year ' . $personalYear . ' of 9'),
        renderValueLine((string) ($targetYear - 1), 'Personal Year ' . $yearNumber($targetYear - 1)),
        renderValueLine($targetYear . ' (selected)', 'Personal Year ' . $personalYear),
        renderValueLine((string) ($targetYear + 1), 'Personal Year ' . $yearNumber($targetYear + 1)),
    ];

    /* One Personal Month per calendar month of the chosen year. */
    $monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July',
        'August', 'September', 'October', 'November', 'December'];
    $today = new DateTime('today');
    $isThisYear = $targetYear === (int) $today->format('Y');
    $thisMonth = (int) $today->format('n');

    $monthLines = [];
    foreach ($monthNames as $index => $monthName) {
        $monthNumber = reduceToSingleDigit($personalYear + $index + 1);
        $theme = $personalYearData['month'][(string) $monthNumber] ?? '';
        $value = 'Personal Month ' . $monthNumber . ($theme !== '' ? ' — ' . $theme : '');
        $label = $monthName . ($isThisYear && $thisMonth === $index + 1 ? ' (this month)' : '');
        $monthLines[] = renderValueLine($label, htmlspecialchars($value));
    }

    return [
        'valid' => true,
        'headerText' => 'Date of Birth: ' . formatLongDate($day, $month, $year)
            . ' | Personal Year ' . $targetYear,
        'processLinesHtml' => implode('', $lines),
        'numValue' => $numDisplay,
        'glanceHtml' => implode('', $glance),
        'monthsTitle' => 'Month by Month in ' . $targetYear,
        'monthsHtml' => implode('', $monthLines),
        'interpretationHtml' => renderReading($personalYearData['year'][(string) $personalYear] ?? null),
    ];
};
