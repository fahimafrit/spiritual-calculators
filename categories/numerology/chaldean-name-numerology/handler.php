<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   CHALDEAN NAME NUMEROLOGY — HANDLER
   Input:  { name: "Full Name" }
   Chaldean letter values (1-8, never 9). Result: the Destiny Number (Name Number) as a
   Compound Number and its Reduced Number (e.g. 30/3), plus the Soul
   Urge (vowels) and Personality (consonants) numbers. No master
   numbers. Output: the rendered result fragments only — never the
   letter table or the interpretation library itself.
   Called through the dispatcher: POST /calculate.php?slug=chaldean-name-numerology
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/chaldean-engine.php';
require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/render.php';

$chaldeanData = require __DIR__ . '/readings.php';

/** "A=1, E=5 = 15 -> 6" style working line. */
function chaldeanWorkingLine(string $label, array $result): string
{
    $letters = implode(', ', array_map(
        fn ($entry) => strtoupper($entry['letter']) . '=' . $entry['value'],
        $result['breakdown']
    ));
    return renderValueLine($label, htmlspecialchars($letters) . ' = ' . renderSteps($result['steps']));
}

return function (array $input) use ($chaldeanData): array {
    $name = trim((string) ($input['name'] ?? ''));
    $check = validateName($name);

    if (!$check['valid']) {
        return ['valid' => false, 'errorsHtml' => $check['errorHtml']];
    }

    $result = computeChaldeanName($name);

    if ($result['breakdown'] === []) {
        return [
            'valid' => false,
            'errorsHtml' => '<p>This name has no letters to calculate from. Check the spelling and try again.</p>',
        ];
    }

    $total = $result['total'];
    $reduced = $result['number'];
    $display = formatChaldeanNumber($total, $reduced);

    /* Calculation process: each word, the total, then the reduction. */
    $lines = [];
    foreach ($result['words'] as $word) {
        $letters = implode(', ', array_map(
            fn ($entry) => strtoupper($entry['letter']) . '=' . $entry['value'],
            $word['breakdown']
        ));
        $lines[] = renderValueLine($word['word'], htmlspecialchars($letters) . ' = ' . $word['total']);
    }
    if (count($result['words']) > 1) {
        $lines[] = renderValueLine(
            'Total',
            implode(' + ', array_column($result['words'], 'total')) . ' = ' . $total
        );
    }
    if ($total > 9) {
        $lines[] = renderValueLine('Compound Number', (string) $total);
        $lines[] = renderValueLine('Reduced Number', renderSteps(array_slice($result['steps'], 1)));
    }
    $lines[] = renderFinalLine('Chaldean Destiny Number (Name Number): ' . $display);

    /* Soul Urge (vowels) and Personality (consonants). A name without
       vowels or consonants simply omits that number. */
    $secondary = [
        'Soul Urge Number' => computeChaldeanName($name, 'vowels'),
        'Personality Number' => computeChaldeanName($name, 'consonants'),
    ];

    $numberLines = [];
    $aliases = ['Soul Urge Number' => "Soul Urge Number (Heart's Desire Number)"];
    /* Heading text per role, in the same form the results show it. */
    $roles = [
        'Destiny Number' => [
            'digit' => $reduced,
            'heading' => 'Destiny Number ' . $reduced,
        ],
    ];

    foreach ($secondary as $label => $part) {
        if ($part['breakdown'] === []) {
            continue;
        }
        $partDisplay = formatChaldeanNumber($part['total'], $part['number']);
        $numberLines[] = renderValueLine($aliases[$label] ?? $label, htmlspecialchars($partDisplay));
        $lines[] = chaldeanWorkingLine($label === 'Soul Urge Number' ? 'Soul Urge (vowels)' : 'Personality (consonants)', $part);
        $roles[$label] = ['digit' => $part['number'], 'heading' => $label . ' ' . $partDisplay];
    }

    /* Readings: the Destiny Number's compound reading first (10-52 only),
       then one reading per distinct reduced digit, headed by every role
       that digit covers. */
    $readings = [];

    if ($total >= 10 && $total <= 52) {
        $readings[] = '<p class="process-label">Compound Number ' . $total . '</p>'
            . renderReading($chaldeanData['compound'][(string) $total] ?? null);
    }

    $groups = [];
    foreach ($roles as $role) {
        $groups[$role['digit']][] = $role['heading'];
    }
    foreach ($groups as $digit => $covered) {
        $readings[] = '<p class="process-label">' . htmlspecialchars(implode(' · ', $covered)) . '</p>'
            . renderReading($chaldeanData['single'][(string) $digit] ?? null);
    }

    return [
        'valid' => true,
        'headerText' => htmlspecialchars(titleCase($name)) . "'s Chaldean Destiny Number",
        'numValue' => $display,
        'numbersHtml' => implode('', $numberLines),
        'processLinesHtml' => implode('', $lines),
        'interpretationHtml' => implode('<hr class="section-divider" />', $readings),
    ];
};
