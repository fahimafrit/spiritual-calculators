<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   LIFE PATH NUMBER — HANDLER
   Input:  { date: "dd/mm/yyyy" }
   Output: the rendered result fragments only — never the reduction
   engine or the interpretation library itself.
   Called through the dispatcher: POST /calculate.php?slug=life-path-number
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/engine.php';
require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/render.php';

$lifePathData = require __DIR__ . '/readings.php';

return function (array $input) use ($lifePathData): array {
    ['errors' => $errors, 'parsed' => $parsed] = validateBirthDate((string) ($input['date'] ?? ''));

    if (!empty($errors)) {
        return ['valid' => false, 'errorsHtml' => renderErrors($errors)];
    }

    ['day' => $day, 'month' => $month, 'year' => $year] = $parsed;

    $lifePath = computeLifePath($day, $month, $year);
    $numDisplay = formatDisplayNumber($lifePath['number']);

    $lines = renderLifePathLines($lifePath, $day, $month, $year);
    $lines[] = renderFinalLine('Life Path Number: ' . $numDisplay);

    return [
        'valid' => true,
        'personalDateText' => 'Date of Birth: ' . formatLongDate($day, $month, $year),
        'processLinesHtml' => implode('', $lines),
        'numValue' => $numDisplay,
        'interpretationHtml' => renderReading($lifePathData[(string) $lifePath['number']] ?? null),
    ];
};
