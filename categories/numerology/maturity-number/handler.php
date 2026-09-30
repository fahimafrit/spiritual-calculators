<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   MATURITY NUMBER — HANDLER
   Input:  { date: "dd/mm/yyyy", name: "Full Birth Name" }
   Maturity = Life Path + Destiny, reduced (master numbers kept).
   Called through the dispatcher: POST /calculate.php?slug=maturity-number
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/engine.php';
require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/render.php';

$maturityData = require __DIR__ . '/readings.php';

return function (array $input) use ($maturityData): array {
    $name = trim((string) ($input['name'] ?? ''));
    $nameCheck = validateName($name);
    ['errors' => $dateErrors, 'parsed' => $parsed] = validateBirthDate((string) ($input['date'] ?? ''));

    $errorsHtml = ($nameCheck['valid'] ? '' : $nameCheck['errorHtml']) . renderErrors($dateErrors);
    if ($errorsHtml !== '') {
        return ['valid' => false, 'errorsHtml' => $errorsHtml];
    }

    ['day' => $day, 'month' => $month, 'year' => $year] = $parsed;

    $lifePath = computeLifePath($day, $month, $year);
    $destiny = computeNameReduction($name);

    $total = $lifePath['number'] + $destiny['number'];
    $maturitySteps = reduceKeepingMasterWithSteps($total);
    $maturityNumber = end($maturitySteps);
    $numDisplay = formatDisplayNumber($maturityNumber);

    $lines = renderLifePathLines($lifePath, $day, $month, $year);
    $lines[] = renderValueLine('Life Path Number', htmlspecialchars(formatDisplayNumber($lifePath['number'])));
    $lines[] = renderLetterValuesLine($destiny['breakdown']);
    $lines[] = renderNameReductionLine($destiny['breakdown'], $destiny['steps'], 'Destiny reduction');
    $lines[] = renderValueLine('Destiny Number', htmlspecialchars(formatDisplayNumber($destiny['number'])));
    $lines[] = renderSumLine('Maturity sum', [$lifePath['number'], $destiny['number']], $total, $maturitySteps);
    $lines[] = renderFinalLine('Maturity Number: ' . $numDisplay);

    return [
        'valid' => true,
        'headerText' => htmlspecialchars(titleCase($name)) . "'s Maturity Number",
        'processLinesHtml' => implode('', $lines),
        'numValue' => $numDisplay,
        'interpretationHtml' => renderReading($maturityData[(string) $maturityNumber] ?? null),
    ];
};
