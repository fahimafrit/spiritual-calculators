<?php
declare(strict_types=1);

/* ════════════════════════════════════════════════════════════════════
   COMPATIBILITY MATRIX — CALCULATE ENDPOINT
   POST { date1: "dd/mm/yyyy", date2: "dd/mm/yyyy" }
   Returns JSON. On success: the header HTML and one id => number map
   for each tab (compat, p1, p2). The formulas that produce those
   numbers never leave the server.
   ════════════════════════════════════════════════════════════════════ */

define('SPIRITUAL_APP', true);

require __DIR__ . '/../php/compatibility-engine.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['valid' => false, 'errorsHtml' => '<p>Method not allowed.</p>']);
    exit;
}

$date1Raw = (string) ($_POST['date1'] ?? '');
$date2Raw = (string) ($_POST['date2'] ?? '');

$check = cm_validateInput($date1Raw, $date2Raw);
if (!$check['valid']) {
    echo json_encode(['valid' => false, 'errorsHtml' => $check['errorsHtml']]);
    exit;
}

$result = cm_buildResult($check['parsed1'], $check['parsed2']);

echo json_encode([
    'valid' => true,
    'headerHtml' => $result['headerHtml'],
    'compat' => $result['compat'],
    'p1' => $result['p1'],
    'p2' => $result['p2'],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);