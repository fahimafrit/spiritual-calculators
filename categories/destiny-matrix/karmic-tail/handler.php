<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   KARMIC TAIL — HANDLER
   Input:  { date: "dd/mm/yyyy", name: "First Name" }
   Output: the header HTML, the id => number map for the chart, and the
   finished karmic tail reading HTML for that one chart. The formulas,
   the cluster lookup and the reading library never leave the server.
   Called through the dispatcher: POST /calculate.php?slug=karmic-tail
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/destiny-matrix/_shared/karmic-engine.php';

return function (array $input): array {
    $dateRaw = (string) ($input['date'] ?? '');
    $name = (string) ($input['name'] ?? '');

    $check = dm_validateInput($dateRaw, $name);
    if (!$check['valid']) {
        return ['valid' => false, 'errorsHtml' => $check['errorsHtml']];
    }

    $result = kt_buildResult($check['parsed'], $name);

    return [
        'valid' => true,
        'headerHtml' => $result['headerHtml'],
        'values' => $result['values'],
        'readingHtml' => $result['readingHtml'],
    ];
};
