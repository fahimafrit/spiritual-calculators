<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   BIRTHDAY NUMBER — HANDLER
   Input:  { date: "dd/mm/yyyy" }
   Uses only the day of birth (never the month or year) as-is.
   No reduction — the birthday number is the exact day of the month.
   Called through the dispatcher: POST /calculate.php?slug=birthday-number
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/engine.php';
require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/render.php';

$birthdayData = require __DIR__ . '/readings.php';

return function (array $input) use ($birthdayData): array {
    ['errors' => $errors, 'parsed' => $parsed] = validateBirthDate((string) ($input['date'] ?? ''));

    if (!empty($errors)) {
        return ['valid' => false, 'errorsHtml' => renderErrors($errors)];
    }

    ['day' => $day, 'month' => $month, 'year' => $year] = $parsed;

    $numDisplay = (string) $day;

    return [
        'valid' => true,
        'headerText' => 'Date of Birth: ' . formatLongDate($day, $month, $year),
        'processLinesHtml' => '',
        'numValue' => $numDisplay,
        'interpretationHtml' => renderReading($birthdayData[(string) $day] ?? null),
    ];
};
