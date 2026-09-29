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

$destinyData = require __DIR__ . '/readings.php';

return function (array $input) use ($destinyData): array {
    $name = trim((string) ($input['name'] ?? ''));
    $check = validateName($name);

    if (!$check['valid']) {
        return ['valid' => false, 'errorsHtml' => $check['errorHtml']];
    }

    ['total' => $total, 'breakdown' => $breakdown] = computeNameNumber($name);

    $letterValuesText = implode(', ', array_map(
        fn ($entry) => strtoupper($entry['letter']) . '=' . $entry['value'],
        $breakdown
    ));

    $totalSteps = reduceKeepingMasterWithSteps($total);
    $destinyNumber = end($totalSteps);
    $numDisplay = formatDisplayNumber($destinyNumber);

    $lines = [];
    $lines[] = '<p class="process-line"><span class="process-label">Letter values:</span> '
        . htmlspecialchars($letterValuesText) . '</p>';
    $lines[] = '<p class="process-line"><span class="process-label">Reduction:</span> '
        . implode('+', array_map(fn ($e) => $e['value'], $breakdown))
        . ' <span class="process-arrow">&#8594;</span> '
        . implode(' <span class="process-arrow">&#8594;</span> ', array_map('strval', $totalSteps))
        . '</p>';
    $lines[] = '<p class="process-line process-final">Destiny Number: ' . $numDisplay . '</p>';

    $entry = $destinyData[(string) $destinyNumber] ?? null;
    if ($entry) {
        $interpretationHtml = '<p><strong>' . htmlspecialchars($entry['title']) . '</strong></p>';
        foreach ($entry['paragraphs'] as $p) {
            $interpretationHtml .= '<p>' . htmlspecialchars($p) . '</p>';
        }
    } else {
        $interpretationHtml = '<p>This reading is being written — check back soon.</p>';
    }

    return [
        'valid' => true,
        'headerText' => htmlspecialchars(titleCase($name)) . "'s Destiny Number",
        'processLinesHtml' => implode('', $lines),
        'numValue' => $numDisplay,
        'interpretationHtml' => $interpretationHtml,
    ];
};