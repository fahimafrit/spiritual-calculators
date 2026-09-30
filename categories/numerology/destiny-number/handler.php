<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   DESTINY NUMBER — HANDLER
   Input:  { name: "Full Birth Name" }
   Output: the rendered result fragments only — never the
   reduction/letter-value engine or the interpretation library itself.
   Called through the dispatcher: POST /calculate.php?slug=destiny-number
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/engine.php';
require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/render.php';

$destinyData = require __DIR__ . '/readings.php';

return function (array $input) use ($destinyData): array {
    $name = trim((string) ($input['name'] ?? ''));
    $check = validateName($name);

    if (!$check['valid']) {
        return ['valid' => false, 'errorsHtml' => $check['errorHtml']];
    }

    $destiny = computeNameReduction($name);
    $numDisplay = formatDisplayNumber($destiny['number']);

    $lines = [
        renderLetterValuesLine($destiny['breakdown']),
        renderNameReductionLine($destiny['breakdown'], $destiny['steps']),
        renderFinalLine('Destiny Number: ' . $numDisplay),
    ];

    return [
        'valid' => true,
        'headerText' => htmlspecialchars(titleCase($name)) . "'s Destiny Number",
        'processLinesHtml' => implode('', $lines),
        'numValue' => $numDisplay,
        'interpretationHtml' => renderReading($destinyData[(string) $destiny['number']] ?? null),
    ];
};
