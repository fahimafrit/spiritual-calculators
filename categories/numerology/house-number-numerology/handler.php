<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   HOUSE NUMBER NUMEROLOGY — HANDLER
   Input:  { number: "12B" }
   The house or apartment number only (never the street name). Every
   digit counts at face value; any letters in the number (12B, A-4)
   are converted with the Pythagorean table (A=1 ... I=9, J=1 ...) and
   added in. The total is reduced to a single digit (1-9), keeping the
   master numbers 11, 22 and 33.
   Words such as "Flat", "Apt" or "Unit" are ignored.
   Output: the rendered result fragments only — never the reduction
   engine or the interpretation library itself.
   Called through the dispatcher: POST /calculate.php?slug=house-number-numerology
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/engine.php';
require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/render.php';

$houseData = require __DIR__ . '/readings.php';

return function (array $input) use ($houseData): array {
    $raw = trim((string) ($input['number'] ?? ''));

    $formatError = [
        'valid' => false,
        'errorsHtml' => renderErrors([
            'Enter your house or apartment number only, for example 12, 12B or 4/7. Leave out the street name.',
        ]),
    ];

    if ($raw === '' || strlen($raw) > 30 || !preg_match('/^[A-Za-z0-9\s\-\/.,#]+$/D', $raw)) {
        return $formatError;
    }

    // Labels people type in front of the number are not part of it.
    $ignoredWords = [
        'no', 'number', 'house', 'home', 'flat', 'apt', 'apartment',
        'unit', 'suite', 'ste', 'room', 'door', 'building', 'bldg', 'plot', 'block',
    ];

    $tokens = preg_split('/[\s,.#]+/', $raw, -1, PREG_SPLIT_NO_EMPTY) ?: [];
    $kept = array_filter(
        $tokens,
        fn ($token) => !in_array(strtolower($token), $ignoredWords, true)
    );
    $core = implode('', $kept);

    $digitCount = strlen(preg_replace('/\D/', '', $core));
    $letterCount = strlen(preg_replace('/[^A-Za-z]/', '', $core));

    if ($digitCount < 1 || $digitCount > 8 || $letterCount > 3) {
        return $formatError;
    }

    $letterValues = getLetterValues();
    $addends = [];
    $letterBreakdown = [];

    foreach (str_split($core) as $char) {
        if (ctype_digit($char)) {
            $addends[] = (int) $char;
        } elseif (ctype_alpha($char)) {
            $value = $letterValues[strtolower($char)] ?? 0;
            $addends[] = $value;
            $letterBreakdown[] = ['letter' => strtolower($char), 'value' => $value];
        }
    }

    $total = array_sum($addends);

    if ($total === 0) {
        return [
            'valid' => false,
            'errorsHtml' => renderErrors(['A house number needs at least one digit other than zero.']),
        ];
    }

    $steps = reduceKeepingMasterWithSteps($total);
    $number = (int) end($steps);
    $numDisplay = formatDisplayNumber($number);

    $lines = [];
    if (!empty($letterBreakdown)) {
        $lines[] = renderLetterValuesLine($letterBreakdown);
    }
    $lines[] = renderValueLine(
        'Total',
        implode(' + ', $addends) . PROCESS_ARROW . renderSteps($steps)
    );
    $lines[] = renderFinalLine('House Number: ' . $numDisplay);

    return [
        'valid' => true,
        'headerText' => 'House Number: ' . preg_replace('/\s+/', ' ', $raw),
        'processLinesHtml' => implode('', $lines),
        'numValue' => $numDisplay,
        'interpretationHtml' => renderReading($houseData[(string) $number] ?? null),
    ];
};
