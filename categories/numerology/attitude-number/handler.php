<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   ATTITUDE NUMBER — HANDLER
   Input:  { date: "dd/mm/yyyy" }
   Uses only the day and month (never the year). Output: the rendered
   result fragments only — never the reduction engine or the
   interpretation library itself.
   Called through the dispatcher: POST /calculate.php?slug=attitude-number
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/engine.php';
require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/render.php';

$attitudeData = require __DIR__ . '/readings.php';

return function (array $input) use ($attitudeData): array {
    ['errors' => $errors, 'parsed' => $parsed] = validateBirthDate((string) ($input['date'] ?? ''));

    if (!empty($errors)) {
        return ['valid' => false, 'errorsHtml' => renderErrors($errors)];
    }

    ['day' => $day, 'month' => $month, 'year' => $year] = $parsed;

    $daySteps = reduceKeepingMasterWithSteps($day);
    $monthSteps = reduceKeepingMasterWithSteps($month);

    $dayFinal = end($daySteps);
    $monthFinal = end($monthSteps);

    $total = $dayFinal + $monthFinal;
    $totalSteps = reduceKeepingMasterWithSteps($total);
    $attitudeNumber = end($totalSteps);
    $numDisplay = formatDisplayNumber($attitudeNumber);

    $lines = [
        renderProcessLine('Birth Day', $day, $daySteps),
        renderProcessLine('Birth Month', $month, $monthSteps),
        renderSumLine('Sum', [$dayFinal, $monthFinal], $total, $totalSteps),
        renderFinalLine('Attitude Number: ' . $numDisplay),
    ];

    return [
        'valid' => true,
        'headerText' => 'Date of Birth: ' . formatLongDate($day, $month, $year),
        'processLinesHtml' => implode('', $lines),
        'numValue' => $numDisplay,
        'interpretationHtml' => renderReading($attitudeData[(string) $attitudeNumber] ?? null),
    ];
};
