<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   LUCKY NUMBER — HANDLER
   Input:  { date: "dd/mm/yyyy", name: "Full Name" }  (both required)
   Returns the visitor's core Pythagorean numbers as a list of lucky
   numbers: Life Path, Birthday, Destiny, Soul Urge and Personality.
   Master numbers (11, 22, 33) are kept for display ("11/2"); their
   readings resolve through the root digit. The Birthday number is the
   day of birth as-is. A digit that repeats across the list is named
   the strongest lucky number.
   Output: the rendered result fragments only — never the reduction
   engine or the interpretation library itself.
   Called through the dispatcher: POST /calculate.php?slug=lucky-number
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/engine.php';
require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/render.php';

$luckyData = require __DIR__ . '/readings.php';

return function (array $input) use ($luckyData): array {
    $rawDate = trim((string) ($input['date'] ?? ''));
    $rawName = trim((string) ($input['name'] ?? ''));

    if ($rawDate === '' || $rawName === '') {
        $message = $rawDate === '' && $rawName === ''
            ? 'Enter your date of birth and your full name.'
            : ($rawDate === '' ? 'Enter your date of birth.' : 'Enter your full name.');
        return ['valid' => false, 'errorsHtml' => renderErrors([$message])];
    }

    ['errors' => $errors, 'parsed' => $parsed] = validateBirthDate($rawDate);

    if (!empty($errors)) {
        return ['valid' => false, 'errorsHtml' => renderErrors($errors)];
    }

    $check = validateName($rawName);
    if (!$check['valid']) {
        return ['valid' => false, 'errorsHtml' => $check['errorHtml']];
    }

    $destiny = computeNameReduction($rawName);
    $soulUrge = computeNameReduction($rawName, 'vowels');
    $personality = computeNameReduction($rawName, 'consonants');

    if ($destiny['breakdown'] === []) {
        return [
            'valid' => false,
            'errorsHtml' => '<p>This name has no letters to calculate from. Check the spelling and try again.</p>',
        ];
    }
    if ($soulUrge['breakdown'] === []) {
        return [
            'valid' => false,
            'errorsHtml' => '<p>This name has no vowels to calculate from. Check the spelling and try again.</p>',
        ];
    }
    if ($personality['breakdown'] === []) {
        return [
            'valid' => false,
            'errorsHtml' => '<p>This name has no consonants to calculate from. Check the spelling and try again.</p>',
        ];
    }

    ['day' => $day, 'month' => $month, 'year' => $year] = $parsed;

    $lifePath = computeLifePath($day, $month, $year);

    /* The list, in display order: label => number shown to the visitor. */
    $numbers = [
        'Life Path Number' => (int) $lifePath['number'],
        'Birthday Number' => $day,
        'Destiny Number' => (int) $destiny['number'],
        'Soul Urge Number' => (int) $soulUrge['number'],
        'Personality Number' => (int) $personality['number'],
    ];

    /* Every reading is keyed by a single digit (1-9). */
    $roots = [];
    foreach ($numbers as $label => $number) {
        $roots[$label] = reduceToSingleDigit($number);
    }

    $listLines = [];
    foreach ($numbers as $label => $number) {
        $listLines[] = renderValueLine(
            $label,
            htmlspecialchars($label === 'Birthday Number' ? (string) $number : formatDisplayNumber($number))
        );
    }

    /* Strongest lucky number: the digit(s) that repeat most often. */
    $counts = array_count_values($roots);
    $max = max($counts);
    if ($max > 1) {
        $strongest = array_keys(array_filter($counts, fn ($count) => $count === $max));
        sort($strongest);
        $listLines[] = renderFinalLine(
            'Strongest Lucky Number: ' . implode(' and ', $strongest)
            . ' (appears ' . $max . ' times)'
        );
    }

    $processLines = renderLifePathLines($lifePath, $day, $month, $year);
    $processLines[] = renderLetterValuesLine($destiny['breakdown'], 'Letter values (all letters)');
    $processLines[] = renderNameReductionLine($destiny['breakdown'], $destiny['steps'], 'Destiny reduction');
    $processLines[] = renderLetterValuesLine($soulUrge['breakdown'], 'Letter values (vowels)');
    $processLines[] = renderNameReductionLine($soulUrge['breakdown'], $soulUrge['steps'], 'Soul Urge reduction');
    $processLines[] = renderLetterValuesLine($personality['breakdown'], 'Letter values (consonants)');
    $processLines[] = renderNameReductionLine($personality['breakdown'], $personality['steps'], 'Personality reduction');

    /* One reading per distinct digit, headed by every number it covers. */
    $groups = [];
    foreach ($numbers as $label => $number) {
        $groups[$roots[$label]][] = str_replace(' Number', '', $label) . ' '
            . ($label === 'Birthday Number' ? $number : formatDisplayNumber($number));
    }

    $readings = [];
    foreach ($groups as $root => $covered) {
        $readings[] = '<p class="process-label">' . htmlspecialchars(implode(' · ', $covered)) . '</p>'
            . renderReading($luckyData[(string) $root] ?? null);
    }

    return [
        'valid' => true,
        'headerText' => htmlspecialchars(titleCase($rawName)) . ' | Date of Birth: ' . formatLongDate($day, $month, $year),
        'numbersHtml' => implode('', $listLines),
        'processLinesHtml' => implode('', $processLines),
        'interpretationHtml' => implode('<hr class="section-divider" />', $readings),
    ];
};
