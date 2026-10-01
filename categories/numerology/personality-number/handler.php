<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   PERSONALITY NUMBER — HANDLER
   Input:  { name: "Full Birth Name" }
   Only the consonants of the name count.
   Called through the dispatcher: POST /calculate.php?slug=personality-number
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/name-calculator.php';

return buildNameCalculatorHandler('Personality Number', 'consonants', require __DIR__ . '/readings.php');
