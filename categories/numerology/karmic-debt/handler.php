<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   KARMIC DEBT — HANDLER
   Input:  { date: "dd/mm/yyyy", name: "Full Birth Name" }
   Checks four sources for the karmic debt numbers 13, 14, 16 and 19:
   Life Path, Destiny, Soul Urge (vowels only) and the birth day.
   Called through the dispatcher: POST /calculate.php?slug=karmic-debt
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/engine.php';
require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/render.php';

$debtData = require __DIR__ . '/readings.php';

return function (array $input) use ($debtData): array {
    $name = trim((string) ($input['name'] ?? ''));
    $nameCheck = validateName($name);
    ['errors' => $dateErrors, 'parsed' => $parsed] = validateBirthDate((string) ($input['date'] ?? ''));

    $errorsHtml = ($nameCheck['valid'] ? '' : $nameCheck['errorHtml']) . renderErrors($dateErrors);
    if ($errorsHtml !== '') {
        return ['valid' => false, 'errorsHtml' => $errorsHtml];
    }

    ['day' => $day, 'month' => $month, 'year' => $year] = $parsed;

    $debtLine = fn (string $source, array $found): string => renderValueLine(
        'Karmic debt in ' . $source,
        $found ? implode(', ', $found) : 'None'
    );

    $lines = [];

    // Life Path
    $lifePath = computeLifePath($day, $month, $year);
    $lifePathDebt = findKarmicDebtInSteps($lifePath['totalSteps']);
    array_push($lines, ...renderLifePathLines($lifePath, $day, $month, $year));
    $lines[] = $debtLine('Life Path', $lifePathDebt);

    // Destiny (every letter)
    $destiny = computeNameReduction($name);
    $destinyDebt = findKarmicDebtInSteps($destiny['steps']);
    $lines[] = renderLetterValuesLine($destiny['breakdown']);
    $lines[] = renderNameReductionLine($destiny['breakdown'], $destiny['steps'], 'Destiny reduction');
    $lines[] = $debtLine('Destiny', $destinyDebt);

    // Soul Urge (vowels only)
    $soul = computeNameReduction($name, 'vowels');
    if ($soul['total'] > 0) {
        $soulDebt = findKarmicDebtInSteps($soul['steps']);
        $lines[] = renderLetterValuesLine($soul['breakdown'], 'Vowel values');
        $lines[] = renderNameReductionLine($soul['breakdown'], $soul['steps'], 'Soul Urge reduction');
    } else {
        $soulDebt = [];
        $lines[] = renderValueLine('Soul Urge', 'No vowels found in this name');
    }
    $lines[] = $debtLine('Soul Urge', $soulDebt);

    // Birthday (the raw birth day itself)
    $birthdayDebt = isKarmicDebtNumber($day) ? [$day] : [];
    $lines[] = renderValueLine('Birthday', (string) $day);
    $lines[] = $debtLine('Birthday', $birthdayDebt);

    $allFound = array_values(array_unique(array_merge($lifePathDebt, $destinyDebt, $soulDebt, $birthdayDebt)));
    sort($allFound);

    $lines[] = renderFinalLine('Karmic Debt: ' . ($allFound ? implode(', ', $allFound) : 'None'));

    $readings = $allFound
        ? array_map(fn ($debt) => $debtData[(string) $debt] ?? null, $allFound)
        : [$debtData['none'] ?? null];

    return [
        'valid' => true,
        'headerText' => htmlspecialchars(titleCase($name)) . "'s Karmic Debt",
        'processLinesHtml' => implode('', $lines),
        'numValue' => $allFound ? implode(', ', $allFound) : 'None',
        'interpretationHtml' => renderReadingList($readings),
    ];
};
