<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   LUCKY NUMBER — HANDLER
   Input:  { date: "dd/mm/yyyy", name: "Full Name" }  (both required)
   The Lucky Number is the Life Path Number plus the Destiny Number,
   added together and reduced to a single digit (1-9). Life Path and
   Destiny keep their master numbers (11, 22, 33) in their own steps;
   the final Lucky Number never does.
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

    $result = computeNameReduction($rawName);

    if ($result['breakdown'] === []) {
        return [
            'valid' => false,
            'errorsHtml' => '<p>This name has no letters to calculate from. Check the spelling and try again.</p>',
        ];
    }

    ['day' => $day, 'month' => $month, 'year' => $year] = $parsed;

    $lifePath = computeLifePath($day, $month, $year);
    $lifePathNumber = (int) $lifePath['number'];
    $destinyNumber = (int) $result['number'];

    $total = $lifePathNumber + $destinyNumber;
    $steps = reduceToSingleDigitWithSteps($total);
    $lucky = (int) end($steps);

    $lines = renderLifePathLines($lifePath, $day, $month, $year);
    $lines[] = renderValueLine('Life Path Number', htmlspecialchars(formatDisplayNumber($lifePathNumber)));
    $lines[] = renderLetterValuesLine($result['breakdown']);
    $lines[] = renderNameReductionLine($result['breakdown'], $result['steps']);
    $lines[] = renderValueLine('Destiny Number', htmlspecialchars(formatDisplayNumber($destinyNumber)));
    $lines[] = renderSumLine('Lucky Number Sum', [$lifePathNumber, $destinyNumber], $total, $steps);
    $lines[] = renderFinalLine('Lucky Number: ' . $lucky);

    return [
        'valid' => true,
        'headerText' => htmlspecialchars(titleCase($rawName)) . ' | Date of Birth: ' . formatLongDate($day, $month, $year),
        'processLinesHtml' => implode('', $lines),
        'numValue' => (string) $lucky,
        'interpretationHtml' => renderReading($luckyData[(string) $lucky] ?? null),
    ];
};
