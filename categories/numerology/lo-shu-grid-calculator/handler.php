<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   LO SHU GRID — HANDLER
   Input:  { date: "dd/mm/yyyy" }
   Builds the grid from every non-zero digit of the date of birth plus
   the Driver Number (day reduced to one digit) and the Conductor
   Number (all digits of the date added and reduced to one digit).
   Both are always reduced to 1-9 — master numbers are not kept.
   Called through the dispatcher: POST /calculate.php?slug=lo-shu-grid-calculator
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/engine.php';
require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/render.php';

$loShuData = require __DIR__ . '/readings.php';

return function (array $input) use ($loShuData): array {
    ['errors' => $errors, 'parsed' => $parsed] = validateBirthDate((string) ($input['date'] ?? ''));

    if (!empty($errors)) {
        return ['valid' => false, 'errorsHtml' => renderErrors($errors)];
    }

    ['day' => $day, 'month' => $month, 'year' => $year] = $parsed;

    /* ── Fixed layout and planes ────────────────────────────────── */
    $rows = [[4, 9, 2], [3, 5, 7], [8, 1, 6]];
    // All eight lines are presented to the user simply as "planes".
    // Display order: horizontal, vertical, then diagonal.
    $planeKeys = ['mind', 'emotional', 'practical', 'thought', 'will', 'action', 'golden', 'silver'];

    /* ── Calculation ────────────────────────────────────────────── */
    $dateDigits = str_replace('0', '', sprintf('%02d%02d%04d', $day, $month, $year));

    $counts = array_fill(1, 9, 0);
    foreach (str_split($dateDigits) as $digit) {
        $counts[(int) $digit]++;
    }

    $driver = reduceToSingleDigit($day);
    $conductor = reduceToSingleDigit(
        sumDigitsOnce($day) + sumDigitsOnce($month) + sumDigitsOnce($year)
    );

    $counts[$driver]++;
    $counts[$conductor]++;

    $present = [];
    $missing = [];
    $repeated = [];
    for ($n = 1; $n <= 9; $n++) {
        if ($counts[$n] === 0) {
            $missing[] = $n;
        } else {
            $present[] = $n;
            if ($counts[$n] >= 2) {
                $repeated[] = $n;
            }
        }
    }

    /* ── Plane status: which of its 3 numbers are present ───────── */
    $planeHave = [];      // key => how many of its 3 numbers are present
    $planePresentNums = []; // key => its numbers that are present
    $planeMissingNums = []; // key => its numbers that are missing
    foreach ($planeKeys as $key) {
        $planePresentNums[$key] = [];
        $planeMissingNums[$key] = [];
        foreach ($loShuData['lines'][$key]['numbers'] as $n) {
            if ($counts[$n] > 0) {
                $planePresentNums[$key][] = $n;
            } else {
                $planeMissingNums[$key][] = $n;
            }
        }
        $planeHave[$key] = count($planePresentNums[$key]);
    }

    // A plane is present when at least one of its numbers is in the grid, missing when none is.
    $presentPlanes = [];
    $missingPlanes = [];
    foreach ($planeKeys as $key) {
        if ($planeHave[$key] > 0) {
            $presentPlanes[] = $key;
        } else {
            $missingPlanes[] = $key;
        }
    }
    // Complete planes first, then partial ones (2 of 3 before 1 of 3); ties keep display order.
    usort($presentPlanes, fn(string $a, string $b): int => $planeHave[$b] <=> $planeHave[$a]);

    /* ── Grid ───────────────────────────────────────────────────── */
    $gridHtml = '<div class="loshu-grid" role="table" aria-label="Lo Shu Grid">';
    foreach ($rows as $row) {
        foreach ($row as $n) {
            if ($counts[$n] > 0) {
                $gridHtml .= '<div class="loshu-cell is-filled" role="cell"><span class="loshu-digits">'
                    . str_repeat((string) $n, $counts[$n]) . '</span></div>';
            } else {
                $gridHtml .= '<div class="loshu-cell is-empty" role="cell"><span class="loshu-empty">'
                    . $n . '</span></div>';
            }
        }
    }
    $gridHtml .= '</div>';

    /* ── Grid at a glance: numbers and planes in one card ───────── */
    $repeatedText = [];
    foreach ($repeated as $n) {
        $repeatedText[] = $n . ' (' . $counts[$n] . ' times)';
    }

    // Plane names for the summary; present planes show how many of their 3 numbers are in the grid.
    $describePlanes = function (array $keys, bool $showCount) use ($loShuData, $planeHave): string {
        if (empty($keys)) {
            return 'None';
        }
        $parts = [];
        foreach ($keys as $key) {
            $name = $loShuData['lines'][$key]['name'];
            $parts[] = $showCount ? $name . ' (' . $planeHave[$key] . ' of 3)' : $name;
        }
        return implode(', ', $parts);
    };

    $summaryHtml = '<div class="process-card">'
        . renderValueLine('Present numbers', htmlspecialchars(implode(', ', $present) ?: 'None'))
        . renderValueLine('Missing numbers', htmlspecialchars(implode(', ', $missing) ?: 'None'))
        . renderValueLine('Repeated numbers', htmlspecialchars(implode(', ', $repeatedText) ?: 'None'))
        . renderValueLine('Present planes', htmlspecialchars($describePlanes($presentPlanes, true)))
        . renderValueLine('Missing planes', htmlspecialchars($describePlanes($missingPlanes, false)))
        . '</div>';

    /* ── Reading helpers ────────────────────────────────────────── */
    $renderReading = function (string $title, string $tag, string $state, string $theme, string $text): string {
        return '<div class="loshu-reading ' . $state . '">'
            . '<div class="loshu-reading-head">'
            . '<span class="loshu-reading-title">' . htmlspecialchars($title) . '</span>'
            . '<span class="loshu-badge ' . $state . '">' . htmlspecialchars($tag) . '</span>'
            . '</div>'
            . '<p class="loshu-reading-theme">' . htmlspecialchars($theme) . '</p>'
            . '<p>' . htmlspecialchars($text) . '</p>'
            . '</div>';
    };

    // A status group: sub-heading plus its cards. An empty group renders nothing.
    $renderGroup = function (string $label, string $cardsHtml): string {
        if ($cardsHtml === '') {
            return '';
        }
        return '<h3 class="loshu-group-title">' . htmlspecialchars($label) . '</h3>' . $cardsHtml;
    };

    /* ── Readings: numbers — present first, then missing ────────── */
    $presentCards = '';
    $missingCards = '';
    for ($n = 1; $n <= 9; $n++) {
        $entry = $loShuData['numbers'][$n];
        $count = $counts[$n];
        if ($count === 0) {
            $missingCards .= $renderReading('Number ' . $n, 'Missing', 'is-missing', $entry['title'], $entry['missing']);
        } elseif ($count === 1) {
            $presentCards .= $renderReading('Number ' . $n, 'Present', 'is-present', $entry['title'], $entry['present']);
        } elseif ($count === 2) {
            $presentCards .= $renderReading('Number ' . $n, 'Repeated 2×', 'is-repeated', $entry['title'], $entry['double']);
        } else {
            $presentCards .= $renderReading('Number ' . $n, 'Repeated ' . $count . '×', 'is-repeated', $entry['title'], $entry['excess']);
        }
    }
    $numbersReadingHtml = $renderGroup('Present numbers', $presentCards)
        . $renderGroup('Missing numbers', $missingCards);

    /* ── Readings: planes — present (complete, then partial), then missing ── */
    $presentPlaneCards = '';
    foreach ($presentPlanes as $key) {
        $line = $loShuData['lines'][$key];
        $have = $planeHave[$key];
        if ($have === 3) {
            $presentPlaneCards .= $renderReading(
                $line['name'],
                'Complete',
                'is-present',
                implode(' · ', $line['numbers']),
                $line['complete']
            );
        } else {
            $presentPlaneCards .= $renderReading(
                $line['name'],
                $have . ' of 3',
                'is-partial',
                'Present: ' . implode(', ', $planePresentNums[$key])
                    . ' · Missing: ' . implode(', ', $planeMissingNums[$key]),
                $line['partial']
            );
        }
    }

    $missingPlaneCards = '';
    foreach ($missingPlanes as $key) {
        $line = $loShuData['lines'][$key];
        $missingPlaneCards .= $renderReading(
            $line['name'],
            'Missing',
            'is-missing',
            implode(' · ', $line['numbers']),
            $line['missing']
        );
    }

    $planesReadingHtml = $renderGroup('Present planes', $presentPlaneCards)
        . $renderGroup('Missing planes', $missingPlaneCards);

    /* ── Readings: Driver and Conductor ─────────────────────────── */
    $coreReadingHtml = '<p><strong>Driver Number ' . $driver . ' (Psychic Number)</strong></p>'
        . '<p>' . htmlspecialchars($loShuData['driver'][$driver]) . '</p>'
        . '<p><strong>Conductor Number ' . $conductor . ' (Destiny Number)</strong></p>'
        . '<p>' . htmlspecialchars($loShuData['conductor'][$conductor]) . '</p>';

    return [
        'valid' => true,
        'headerText' => 'Date of Birth: ' . formatLongDate($day, $month, $year),
        'driver' => $driver,
        'conductor' => $conductor,
        'gridHtml' => $gridHtml,
        'summaryHtml' => $summaryHtml,
        'numbersReadingHtml' => $numbersReadingHtml,
        'planesReadingHtml' => $planesReadingHtml,
        'coreReadingHtml' => $coreReadingHtml,
    ];
};