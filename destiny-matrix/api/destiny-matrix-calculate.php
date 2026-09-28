<?php
declare(strict_types=1);

/* ════════════════════════════════════════════════════════════════════
   DESTINY MATRIX — CHART ENDPOINT
   POST { date: "dd/mm/yyyy", name: "First Name" }
   Returns JSON. On success: the header HTML and one id => number map
   for the chart, purposes, year points and chakra table. The formulas
   that produce those numbers never leave the server.
   ════════════════════════════════════════════════════════════════════ */

define('SPIRITUAL_APP', true);

require __DIR__ . '/../php/engine.php';

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

$parsed = $check['parsed'];
$person = dm_calculateFromDate($parsed);

$fullDate = dm_formatLongDate($parsed['day'], $parsed['month'], $parsed['year']);
$headerHtml = htmlspecialchars(dm_titleCase($name), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
    . "'s <span class=\"gray\">Destiny Matrix Chart — Date of Birth: " . $fullDate . '</span>';

echo json_encode([
    'valid' => true,
    'headerHtml' => $headerHtml,
    'values' => dm_buildValues($person),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);