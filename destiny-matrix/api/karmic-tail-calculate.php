<?php
declare(strict_types=1);

/* ════════════════════════════════════════════════════════════════════
   KARMIC TAIL — CALCULATE ENDPOINT
   POST { date: "dd/mm/yyyy", name: "First Name" }
   Returns JSON. On success: the header HTML, the id => number map for
   the chart, and the finished karmic tail reading HTML for that one
   chart. The formulas, the cluster lookup and the reading library
   never leave the server.
   ════════════════════════════════════════════════════════════════════ */

define('SPIRITUAL_APP', true);

require __DIR__ . '/../php/karmic-engine.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['valid' => false, 'errorsHtml' => '<p>Method not allowed.</p>']);
    exit;
}

$dateRaw = (string) ($_POST['date'] ?? '');
$name = (string) ($_POST['name'] ?? '');

$check = dm_validateInput($dateRaw, $name);
if (!$check['valid']) {
    echo json_encode(['valid' => false, 'errorsHtml' => $check['errorsHtml']]);
    exit;
}

$result = kt_buildResult($check['parsed'], $name);

echo json_encode([
    'valid' => true,
    'headerHtml' => $result['headerHtml'],
    'values' => $result['values'],
    'readingHtml' => $result['readingHtml'],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);