<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   HTTP HELPERS
   One place for JSON output, error responses and the POST-only check.
   Error responses keep the shape the pages already expect:
   { valid: false, errorsHtml: "<p>...</p>" }
   ════════════════════════════════════════════════════════════════════ */

function sc_json_response(array $payload, int $status = 200): never
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    header('X-Content-Type-Options: nosniff');
    header('Cache-Control: no-store');
    echo json_encode(
        $payload,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE
    );
    exit;
}

function sc_error(string $message, int $status): never
{
    sc_json_response([
        'valid' => false,
        'errorsHtml' => '<p>' . htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</p>',
    ], $status);
}

function sc_require_post(): void
{
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        header('Allow: POST');
        sc_error('Method not allowed.', 405);
    }
}