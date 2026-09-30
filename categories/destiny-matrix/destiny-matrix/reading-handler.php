<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   DESTINY MATRIX — READING HANDLER
   Input:  { date: "dd/mm/yyyy" }
   Output: the finished reading HTML for that one birth date. The chart
   is recomputed from the date here, so the browser never sends points,
   and the manifest, lookup rules and reading library never leave the
   server.
   Called through the dispatcher:
   POST /calculate.php?slug=destiny-matrix-reading
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/destiny-matrix/_shared/engine.php';
require_once SPIRITUAL_ROOT . '/categories/destiny-matrix/_shared/reading-builder.php';

return function (array $input): array {
    $dateRaw = (string) ($input['date'] ?? '');

    $check = dm_validateInput($dateRaw, null);
    if (!$check['valid']) {
        return ['valid' => false, 'errorsHtml' => $check['errorsHtml']];
    }

    $person = dm_calculateFromDate($check['parsed']);
    $currentYearArcana = dm_calculateYear((int) date('Y'));

    return [
        'valid' => true,
        'html' => dm_buildReadingHtml($person, $currentYearArcana),
    ];
};
