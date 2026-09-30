<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   KARMIC LESSONS — HANDLER
   Input:  { name: "Full Birth Name" }
   A karmic lesson is a number 1-9 that never appears among the
   letter values of the name.
   Called through the dispatcher: POST /calculate.php?slug=karmic-lessons
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/engine.php';
require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/render.php';

$lessonData = require __DIR__ . '/readings.php';

return function (array $input) use ($lessonData): array {
    $name = trim((string) ($input['name'] ?? ''));
    $check = validateName($name);

    if (!$check['valid']) {
        return ['valid' => false, 'errorsHtml' => $check['errorHtml']];
    }

    ['breakdown' => $breakdown] = computeNameNumber($name);
    $counts = countNumberFrequencies($breakdown);
    $missing = array_keys(array_filter($counts, fn ($count) => $count === 0));

    $frequencyText = implode(', ', array_map(
        fn ($number, $count) => $number . '&times;' . $count,
        array_keys($counts),
        $counts
    ));

    $lines = [
        renderLetterValuesLine($breakdown),
        renderValueLine('Number frequency', $frequencyText),
        renderFinalLine('Karmic Lessons: ' . ($missing ? implode(', ', $missing) : 'None')),
    ];

    $readings = $missing
        ? array_map(fn ($number) => $lessonData[(string) $number] ?? null, $missing)
        : [$lessonData['none'] ?? null];

    return [
        'valid' => true,
        'headerText' => htmlspecialchars(titleCase($name)) . "'s Karmic Lessons",
        'processLinesHtml' => implode('', $lines),
        'numValue' => $missing ? implode(', ', $missing) : 'None',
        'interpretationHtml' => renderReadingList($readings),
    ];
};
