<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   DESTINY MATRIX — CHART HANDLER
   Input:  { date: "dd/mm/yyyy", name: "First Name" }
   Output: the header HTML and one id => number map for the chart,
   purposes, year points and chakra table. The formulas that produce
   those numbers never leave the server.
   Called through the dispatcher: POST /calculate.php?slug=destiny-matrix
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/destiny-matrix/_shared/engine.php';

return function (array $input): array {
    $dateRaw = (string) ($input['date'] ?? '');
    $name = (string) ($input['name'] ?? '');

    $check = dm_validateInput($dateRaw, $name);
    if (!$check['valid']) {
        return ['valid' => false, 'errorsHtml' => $check['errorsHtml']];
    }

    $parsed = $check['parsed'];
    $person = dm_calculateFromDate($parsed);

    $fullDate = dm_formatLongDate($parsed['day'], $parsed['month'], $parsed['year']);
    $headerHtml = htmlspecialchars(dm_titleCase($name), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
        . "'s <span class=\"gray\">Destiny Matrix Chart — Date of Birth: " . $fullDate . '</span>';

    return [
        'valid' => true,
        'headerHtml' => $headerHtml,
        'values' => dm_buildValues($person),
    ];
};
