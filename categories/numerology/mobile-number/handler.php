<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   MOBILE NUMBER — HANDLER
   Input:  { number: "+1 (555) 123-4567" }
   Every digit entered counts. Spaces, dashes, dots, brackets and a
   plus sign are ignored. The digits are added together and reduced to
   a single digit (1-9); master numbers get no special treatment.
   Output: the rendered result fragments only — never the reduction
   engine or the interpretation library itself.
   Called through the dispatcher: POST /calculate.php?slug=mobile-number
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/engine.php';
require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/render.php';

$mobileData = require __DIR__ . '/readings.php';

return function (array $input) use ($mobileData): array {
    $raw = trim((string) ($input['number'] ?? ''));

    if ($raw === '' || !preg_match('/^[0-9+\-\s().]+$/D', $raw)) {
        return [
            'valid' => false,
            'errorsHtml' => renderErrors([
                'Enter a mobile number using digits only (spaces, dashes, brackets and + are fine).',
            ]),
        ];
    }

    $digits = preg_replace('/\D/', '', $raw);
    $count = strlen($digits);

    if ($count < 5 || $count > 15) {
        return [
            'valid' => false,
            'errorsHtml' => renderErrors(['A mobile number needs between 5 and 15 digits.']),
        ];
    }

    $digitList = array_map('intval', str_split($digits));
    $total = array_sum($digitList);

    if ($total === 0) {
        return [
            'valid' => false,
            'errorsHtml' => renderErrors(['A mobile number needs at least one digit other than zero.']),
        ];
    }

    $steps = reduceToSingleDigitWithSteps($total);
    $number = (int) end($steps);

    $lines = [
        renderValueLine(
            'Digit sum',
            implode('+', $digitList) . PROCESS_ARROW . renderSteps($steps)
        ),
        renderFinalLine('Mobile Number: ' . $number),
    ];

    return [
        'valid' => true,
        'headerText' => 'Mobile Number: ' . $raw,
        'processLinesHtml' => implode('', $lines),
        'numValue' => (string) $number,
        'interpretationHtml' => renderReading($mobileData[(string) $number] ?? null),
    ];
};