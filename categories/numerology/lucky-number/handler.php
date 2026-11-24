<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   LUCKY NUMBER — HANDLER
   Input:  { date: "yyyy-mm-dd" }  (preferred, birth date)
           { name: "..." }         (fallback, full name)
   At least one of the two is required; the date wins when both are
   sent. The Lucky Number is the Life Path Number derived from the
   birth date; with only a name it falls back to the Destiny
   (Expression) Number. Master numbers (11, 22, 33) are kept for
   display ("11/2") and the reading resolves through their root digit.
   Output: the rendered result fragments only — never the reduction
   engine or the interpretation library itself.
   Called through the dispatcher: POST /calculate.php?slug=lucky-number
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/engine.php';
require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/render.php';

$luckyData = require __DIR__ . '/readings.php';

/**
 * Accepts both dd/mm/yyyy (typed) and yyyy-mm-dd (sent by FormKit's
 * classic layouts), then applies the shared birth-date rules.
 *
 * @return array{errors:string[], parsed:?array{day:int,month:int,year:int}}
 */
function luckyValidateDate(string $raw): array
{
    if ($raw !== '' && preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $raw, $m)) {
        $raw = $m[3] . '/' . $m[2] . '/' . $m[1];
    }
    return validateBirthDate($raw);
}

/**
 * Readings are keyed by single digit (1-9). A master number result
 * resolves through its root digit so every result finds a reading.
 */
function luckyReading(array $data, int $number): ?array
{
    $key = (string) (isMasterNumber($number) ? reduceToSingleDigit($number) : $number);
    return $data[$key] ?? null;
}

return function (array $input) use ($luckyData): array {
    $rawDate = trim((string) ($input['date'] ?? ''));
    $rawName = trim((string) ($input['name'] ?? ''));

    if ($rawDate === '' && $rawName === '') {
        return [
            'valid' => false,
            'errorsHtml' => renderErrors([
                'Enter your date of birth, your full name, or both.',
            ]),
        ];
    }

    /* Preferred path: the birth date (Life Path based lucky number). */
    if ($rawDate !== '') {
        ['errors' => $errors, 'parsed' => $parsed] = luckyValidateDate($rawDate);

        if (!empty($errors)) {
            return ['valid' => false, 'errorsHtml' => renderErrors($errors)];
        }

        ['day' => $day, 'month' => $month, 'year' => $year] = $parsed;

        $lifePath = computeLifePath($day, $month, $year);
        $number = (int) $lifePath['number'];
        $numDisplay = formatDisplayNumber($number);

        $lines = renderLifePathLines($lifePath, $day, $month, $year);
        $lines[] = renderFinalLine('Lucky Number: ' . $numDisplay);

        return [
            'valid' => true,
            'headerText' => 'Date of Birth: ' . formatLongDate($day, $month, $year),
            'processLinesHtml' => implode('', $lines),
            'numValue' => $numDisplay,
            'interpretationHtml' => renderReading(luckyReading($luckyData, $number)),
        ];
    }

    /* Fallback path: the full name (Destiny Number based lucky number). */
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

    $number = (int) $result['number'];
    $numDisplay = formatDisplayNumber($number);

    $lines = [
        renderLetterValuesLine($result['breakdown']),
        renderNameReductionLine($result['breakdown'], $result['steps']),
        renderFinalLine('Lucky Number: ' . $numDisplay),
    ];

    return [
        'valid' => true,
        'headerText' => htmlspecialchars(titleCase($rawName)) . "'s Lucky Number",
        'processLinesHtml' => implode('', $lines),
        'numValue' => $numDisplay,
        'interpretationHtml' => renderReading(luckyReading($luckyData, $number)),
    ];
};
