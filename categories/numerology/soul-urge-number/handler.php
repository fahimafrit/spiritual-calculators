<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   SOUL URGE NUMBER — HANDLER
   Input:  { name: "Full Birth Name" }
   Only the vowels (A, E, I, O, U) of the name count.
   Called through the dispatcher: POST /calculate.php?slug=soul-urge-number
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/name-calculator.php';

return buildNameCalculatorHandler('Soul Urge Number', 'vowels', require __DIR__ . '/readings.php');
