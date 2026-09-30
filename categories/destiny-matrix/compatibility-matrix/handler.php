<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   COMPATIBILITY MATRIX — HANDLER
   Input:  { date1: "dd/mm/yyyy", date2: "dd/mm/yyyy" }
   Output: the header HTML and one id => number map for each tab
   (compat, p1, p2). The formulas that produce those numbers never
   leave the server.
   Called through the dispatcher: POST /calculate.php?slug=compatibility-matrix
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/destiny-matrix/_shared/compatibility-engine.php';

return function (array $input): array {
    $date1Raw = (string) ($input['date1'] ?? '');
    $date2Raw = (string) ($input['date2'] ?? '');

    $check = cm_validateInput($date1Raw, $date2Raw);
    if (!$check['valid']) {
        return ['valid' => false, 'errorsHtml' => $check['errorsHtml']];
    }

    $result = cm_buildResult($check['parsed1'], $check['parsed2']);

    return [
        'valid' => true,
        'headerHtml' => $result['headerHtml'],
        'compat' => $result['compat'],
        'p1' => $result['p1'],
        'p2' => $result['p2'],
    ];
};
