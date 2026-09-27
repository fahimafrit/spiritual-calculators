<?php
declare(strict_types=1);

/* ════════════════════════════════════════════════════════════════════
   DESTINY NUMBER — CALCULATE ENDPOINT
   POST { name: "Full Birth Name" }
   Returns JSON. On success, the rendered result fragments only —
   never the reduction/letter-value engine or the interpretation
   library itself.
   ════════════════════════════════════════════════════════════════════ */

define('SPIRITUAL_APP', true);

require __DIR__ . '/../php/engine.php';
$destinyData = require __DIR__ . '/../php/destiny-number-data.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['valid' => false, 'errorsHtml' => '<p>Method not allowed.</p>']);
    exit;
}

$name = trim((string) ($_POST['name'] ?? ''));
$check = validateName($name);

if (!$check['valid']) {
    echo json_encode(['valid' => false, 'errorsHtml' => $check['errorHtml']]);
    exit;
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

echo json_encode([
    'valid' => true,
    'headerText' => htmlspecialchars(titleCase($name)) . "'s Destiny Number",
    'processLinesHtml' => implode('', $lines),
    'numValue' => $numDisplay,
    'interpretationHtml' => $interpretationHtml,
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);