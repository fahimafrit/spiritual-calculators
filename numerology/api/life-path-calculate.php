<?php
declare(strict_types=1);

/* ════════════════════════════════════════════════════════════════════
   LIFE PATH NUMBER — CALCULATE ENDPOINT
   POST { date: "dd/mm/yyyy" }
   Returns JSON. On success, the rendered result fragments only —
   never the reduction engine or the interpretation library itself.
   ════════════════════════════════════════════════════════════════════ */

define('SPIRITUAL_APP', true);

require __DIR__ . '/../php/engine.php';
$lifePathData = require __DIR__ . '/../php/life-path-data.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['valid' => false, 'errorsHtml' => '<p>Method not allowed.</p>']);
    exit;
}

function processLine(string $label, int $raw, array $steps, bool $finalLine = false): string
{
    $inner = '<span class="process-label">' . htmlspecialchars($label) . ':</span> ' . $raw
        . ' <span class="process-arrow">&#8594;</span> '
        . implode(' <span class="process-arrow">&#8594;</span> ', array_map('strval', $steps));
    $class = 'process-line' . ($finalLine ? ' process-final' : '');
    return '<p class="' . $class . '">' . $inner . '</p>';
}

$dateRaw = (string) ($_POST['date'] ?? '');
$parsed = parseDdMmYyyy($dateRaw);
$errors = [];

if (!isValidCalendarDate($parsed)) {
    $errors[] = 'Date is not valid. Use dd/mm/yyyy.';
} elseif (isDateInFuture($parsed)) {
    $errors[] = "Date can't be in the future.";
}

if (!empty($errors)) {
    $errorsHtml = '';
    foreach ($errors as $e) {
        $errorsHtml .= '<p>' . htmlspecialchars($e) . '</p>';
    }
    echo json_encode(['valid' => false, 'errorsHtml' => $errorsHtml]);
    exit;
}

$day = $parsed['day'];
$month = $parsed['month'];
$year = $parsed['year'];

$daySteps = reduceKeepingMasterWithSteps($day);
$monthSteps = reduceKeepingMasterWithSteps($month);
$yearSteps = reduceKeepingMasterWithSteps($year);

$dayFinal = end($daySteps);
$monthFinal = end($monthSteps);
$yearFinal = end($yearSteps);

$total = $dayFinal + $monthFinal + $yearFinal;
$totalSteps = reduceKeepingMasterWithSteps($total);
$lifePathNumber = end($totalSteps);
$numDisplay = formatDisplayNumber($lifePathNumber);

$lines = [];
$lines[] = processLine('Birth Day', $day, $daySteps);
$lines[] = processLine('Birth Month', $month, $monthSteps);
$lines[] = processLine('Birth Year', $year, $yearSteps);
$lines[] = '<p class="process-line"><span class="process-label">Sum:</span> '
    . $dayFinal . ' + ' . $monthFinal . ' + ' . $yearFinal . ' = ' . $total
    . ' <span class="process-arrow">&#8594;</span> '
    . implode(' <span class="process-arrow">&#8594;</span> ', array_map('strval', $totalSteps))
    . '</p>';
$lines[] = '<p class="process-line process-final">Life Path Number: ' . $numDisplay . '</p>';

$entry = $lifePathData[(string) $lifePathNumber] ?? null;
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
    'personalDateText' => 'Date of Birth: ' . formatLongDate($day, $month, $year),
    'processLinesHtml' => implode('', $lines),
    'numValue' => $numDisplay,
    'interpretationHtml' => $interpretationHtml,
], JSON_UNESCAPED_SLASHES);