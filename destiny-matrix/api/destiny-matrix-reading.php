<?php
declare(strict_types=1);

/* ════════════════════════════════════════════════════════════════════
   DESTINY MATRIX — READING ENDPOINT
   POST { date: "dd/mm/yyyy" }
   Returns JSON. On success: the finished reading HTML for that one
   birth date. The chart is recomputed from the date here, so the
   browser never sends points, and the manifest, lookup rules and
   reading library never leave the server.
   ════════════════════════════════════════════════════════════════════ */

define('SPIRITUAL_APP', true);

require __DIR__ . '/../php/engine.php';
require __DIR__ . '/../php/reading-builder.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['valid' => false, 'errorsHtml' => '<p>Method not allowed.</p>']);
    exit;
}

$dateRaw = (string) ($_POST['date'] ?? '');

$check = dm_validateInput($dateRaw, null);
if (!$check['valid']) {
    echo json_encode(['valid' => false, 'errorsHtml' => $check['errorsHtml']]);
    exit;
}

$person = dm_calculateFromDate($check['parsed']);
$currentYearArcana = dm_calculateYear((int) date('Y'));

echo json_encode([
    'valid' => true,
    'html' => dm_buildReadingHtml($person, $currentYearArcana),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);