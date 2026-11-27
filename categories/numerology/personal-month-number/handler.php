<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   PERSONAL MONTH NUMBER — HANDLER
   Input:  { date: "dd/mm/yyyy", month: "1".."12", year: "yyyy" }
   Personal Month = Personal Year + calendar month, reduced to a single
   digit 1-9 (no master numbers kept at any step). The Personal Year
   comes from the birth day and month plus the chosen year; the birth
   year is not used. Month and year default to today's when not sent.
   Besides the number, the result shows the Personal Year it belongs
   to and the previous and next month (a month in another calendar
   year uses that year's Personal Year). Output: the rendered result
   fragments only — never the reduction engine or the interpretation
   library itself.
   Called through the dispatcher: POST /calculate.php?slug=personal-month-number
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/engine.php';
require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/render.php';

$personalMonthData = require __DIR__ . '/readings.php';

return function (array $input) use ($personalMonthData): array {
    ['errors' => $errors, 'parsed' => $parsed] = validateBirthDate((string) ($input['date'] ?? ''));

    if (!empty($errors)) {
        return ['valid' => false, 'errorsHtml' => renderErrors($errors)];
    }

    ['day' => $day, 'month' => $month, 'year' => $year] = $parsed;

    $today = new DateTime('today');

    if (!isset($input['month'])) {
        $targetMonth = (int) $today->format('n');
    } else {
        $rawMonth = trim((string) $input['month']);
        if (!preg_match('/^\d{1,2}$/D', $rawMonth) || (int) $rawMonth < 1 || (int) $rawMonth > 12) {
            return ['valid' => false, 'errorsHtml' => renderErrors(['Choose a month.'])];
        }
        $targetMonth = (int) $rawMonth;
    }

    if (!isset($input['year'])) {
        $targetYear = (int) $today->format('Y');
    } else {
        $rawYear = trim((string) $input['year']);
        if (!preg_match('/^\d{4}$/D', $rawYear) || (int) $rawYear < 1900 || (int) $rawYear > 2100) {
            return ['valid' => false, 'errorsHtml' => renderErrors(['Enter a year between 1900 and 2100.'])];
        }
        $targetYear = (int) $rawYear;
    }

    $monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July',
        'August', 'September', 'October', 'November', 'December'];

    $daySteps = reduceToSingleDigitWithSteps($day);
    $monthSteps = reduceToSingleDigitWithSteps($month);
    $yearSteps = reduceToSingleDigitWithSteps($targetYear);

    $dayFinal = end($daySteps);
    $monthFinal = end($monthSteps);
    $yearFinal = end($yearSteps);

    $yearTotal = $dayFinal + $monthFinal + $yearFinal;
    $yearTotalSteps = reduceToSingleDigitWithSteps($yearTotal);
    $personalYear = end($yearTotalSteps);

    $monthTotal = $personalYear + $targetMonth;
    $monthTotalSteps = reduceToSingleDigitWithSteps($monthTotal);
    $personalMonth = end($monthTotalSteps);
    $numDisplay = (string) $personalMonth;

    $monthLabel = $monthNames[$targetMonth - 1] . ' ' . $targetYear;

    $lines = [
        renderProcessLine('Birth Day', $day, $daySteps),
        renderProcessLine('Birth Month', $month, $monthSteps),
        renderProcessLine('Year', $targetYear, $yearSteps),
        renderSumLine('Personal Year', [$dayFinal, $monthFinal, $yearFinal], $yearTotal, $yearTotalSteps),
        renderSumLine('Personal Month', [$personalYear, $targetMonth], $monthTotal, $monthTotalSteps),
        renderFinalLine('Personal Month Number for ' . $monthLabel . ': ' . $numDisplay),
    ];

    /* Personal Month of any month, from the same birth day and month. */
    $yearNumber = static fn (int $y): int => reduceToSingleDigit($dayFinal + $monthFinal + reduceToSingleDigit($y));
    $monthNumber = static fn (int $y, int $m): int => reduceToSingleDigit($yearNumber($y) + $m);

    $prevMonth = $targetMonth === 1 ? 12 : $targetMonth - 1;
    $prevYear = $targetMonth === 1 ? $targetYear - 1 : $targetYear;
    $nextMonth = $targetMonth === 12 ? 1 : $targetMonth + 1;
    $nextYear = $targetMonth === 12 ? $targetYear + 1 : $targetYear;

    $glance = [
        renderValueLine('Personal Year ' . $targetYear, (string) $personalYear),
        renderValueLine($monthNames[$prevMonth - 1] . ' ' . $prevYear, 'Personal Month ' . $monthNumber($prevYear, $prevMonth)),
        renderValueLine($monthLabel . ' (selected)', 'Personal Month ' . $personalMonth),
        renderValueLine($monthNames[$nextMonth - 1] . ' ' . $nextYear, 'Personal Month ' . $monthNumber($nextYear, $nextMonth)),
    ];

    return [
        'valid' => true,
        'headerText' => 'Date of Birth: ' . formatLongDate($day, $month, $year)
            . ' | Personal Month: ' . $monthLabel,
        'processLinesHtml' => implode('', $lines),
        'numValue' => $numDisplay,
        'glanceHtml' => implode('', $glance),
        'interpretationHtml' => renderReading($personalMonthData[(string) $personalMonth] ?? null),
    ];
};
