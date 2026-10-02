<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   LIFE PATH COMPATIBILITY — HANDLER
   Input:  { date1: "dd/mm/yyyy", date2: "dd/mm/yyyy" }
   Each date gives a Life Path Number (masters 11/22/33 kept, exactly as
   in the Life Path Number calculator). The pair is then scored and read.
   Master numbers are matched through their root digit (11 -> 2,
   22 -> 4, 33 -> 6). Output: rendered result fragments only.
   Called through the dispatcher: POST /calculate.php?slug=life-path-compatibility
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/engine.php';
require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/render.php';

$pairData = require __DIR__ . '/readings.php';

function lpcLevelLabel(int $score): string
{
    if ($score >= 85) return 'Excellent Match';
    if ($score >= 75) return 'Strong Match';
    if ($score >= 60) return 'Moderate Match';
    return 'Challenging Match';
}

return function (array $input) use ($pairData): array {
    $check1 = validateBirthDate((string) ($input['date1'] ?? ''));
    $check2 = validateBirthDate((string) ($input['date2'] ?? ''));

    $errors = [];
    foreach ($check1['errors'] as $message) {
        $errors[] = 'Partner 1: ' . $message;
    }
    foreach ($check2['errors'] as $message) {
        $errors[] = 'Partner 2: ' . $message;
    }
    if (!empty($errors)) {
        return ['valid' => false, 'errorsHtml' => renderErrors($errors)];
    }

    $people = [];
    foreach ([$check1['parsed'], $check2['parsed']] as $parsed) {
        ['day' => $day, 'month' => $month, 'year' => $year] = $parsed;
        $lifePath = computeLifePath($day, $month, $year);
        $lines = renderLifePathLines($lifePath, $day, $month, $year);
        $lines[] = renderFinalLine('Life Path Number: ' . formatDisplayNumber($lifePath['number']));
        $people[] = [
            'number' => $lifePath['number'],
            'dateText' => formatLongDate($day, $month, $year),
            'numValue' => formatDisplayNumber($lifePath['number']),
            'processLinesHtml' => implode('', $lines),
        ];
    }

    $roots = [
        reduceToSingleDigit($people[0]['number']),
        reduceToSingleDigit($people[1]['number']),
    ];
    sort($roots);
    $pairKey = $roots[0] . '-' . $roots[1];

    $score = (int) ($pairData['scores'][$pairKey] ?? 0);
    $interpretationHtml = renderReading($pairData['readings'][$pairKey] ?? null);

    foreach ([$people[0]['number'], $people[1]['number']] as $number) {
        if (isMasterNumber($number) && isset($pairData['masterNotes'][(string) $number])) {
            $interpretationHtml .= '<p>' . htmlspecialchars($pairData['masterNotes'][(string) $number]) . '</p>';
        }
    }

    return [
        'valid' => true,
        'person1' => $people[0],
        'person2' => $people[1],
        'score' => $score,
        'levelLabel' => lpcLevelLabel($score),
        'interpretationHtml' => $interpretationHtml,
    ];
};
