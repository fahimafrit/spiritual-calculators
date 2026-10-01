<?php
declare(strict_types=1);

/* ════════════════════════════════════════════════════════════════════
   NUMEROLOGY CORE — NAME-BASED CALCULATOR BUILDER (PHP)
   Every calculator that turns a name into one number (Destiny Number,
   Soul Urge, Personality) works the same way: validate the name,
   pick which letters count, reduce, render. This file builds that
   handler once. A calculator supplies only its label, its letter
   filter, and its readings. Never included directly from a browser
   request.
   ════════════════════════════════════════════════════════════════════ */

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/engine.php';
require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/render.php';

/**
 * Builds the handler function for a name-based calculator.
 *
 * @param string   $label     e.g. "Soul Urge Number" (used in the header and final line)
 * @param ?string  $filter    null = every letter, 'vowels', or 'consonants'
 * @param array    $readings  interpretation entries keyed by final number
 */
function buildNameCalculatorHandler(string $label, ?string $filter, array $readings): callable
{
    return function (array $input) use ($label, $filter, $readings): array {
        $name = trim((string) ($input['name'] ?? ''));
        $check = validateName($name);

        if (!$check['valid']) {
            return ['valid' => false, 'errorsHtml' => $check['errorHtml']];
        }

        $result = computeNameReduction($name, $filter);

        if ($result['breakdown'] === []) {
            $missing = $filter === 'vowels' ? 'vowels' : 'consonants';
            return [
                'valid' => false,
                'errorsHtml' => '<p>This name has no ' . $missing . ' to calculate from. Check the spelling and try again.</p>',
            ];
        }

        $numDisplay = formatDisplayNumber($result['number']);

        $lines = [
            renderLetterValuesLine($result['breakdown']),
            renderNameReductionLine($result['breakdown'], $result['steps']),
            renderFinalLine($label . ': ' . $numDisplay),
        ];

        return [
            'valid' => true,
            'headerText' => htmlspecialchars(titleCase($name)) . "'s " . $label,
            'processLinesHtml' => implode('', $lines),
            'numValue' => $numDisplay,
            'interpretationHtml' => renderReading($readings[(string) $result['number']] ?? null),
        ];
    };
}
