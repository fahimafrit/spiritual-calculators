<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   DISPATCHER
   One entry point for every calculator.
     POST /calculate.php?slug=life-path-number   (fields in the body)

   A handler file returns a function that takes the input array and
   returns the result array:

     return function (array $input): array { ... };

   The dispatcher does everything around it: POST check, slug lookup,
   input limits, JSON output and error handling.
   ════════════════════════════════════════════════════════════════════ */

function sc_dispatch(): never
{
    sc_require_post();

    $slug = (string) ($_GET['slug'] ?? '');
    $calculator = sc_find_calculator($slug);
    if ($calculator === null) {
        sc_error('Calculator not found.', 404);
    }

    $input = [];
    foreach ($_POST as $key => $value) {
        if (
            !is_string($key) || !preg_match('/^[A-Za-z0-9_]{1,40}$/', $key)
            || !is_string($value) || strlen($value) > 500
        ) {
            sc_error('Invalid input.', 400);
        }
        $input[$key] = $value;
    }

    try {
        $handler = require $calculator['handler'];

        if (!is_callable($handler)) {
            throw new RuntimeException('Handler did not return a function: ' . $calculator['slug']);
        }

        $result = $handler($input);

        if (!is_array($result)) {
            throw new RuntimeException('Handler did not return an array: ' . $calculator['slug']);
        }

        sc_json_response($result);
    } catch (Throwable $e) {
        error_log('[spiritual] ' . $calculator['slug'] . ': ' . $e->getMessage());
        sc_error('Something went wrong. Please try again.', 500);
    }
}