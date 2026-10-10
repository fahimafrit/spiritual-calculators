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

    /* ── Fixed layout and lines ─────────────────────────────────── */
    $rows = [[4, 9, 2], [3, 5, 7], [8, 1, 6]];
    $lineGroups = [
        'Horizontal planes' => ['mind', 'emotional', 'practical'],
        'Vertical planes'   => ['thought', 'will', 'action'],
        'Diagonal yogs'     => ['golden', 'silver'],
    ];

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

    /* ── Driver / Conductor cards ───────────────────────────────── */
    $coreHtml = '<div class="loshu-core">'
        . '<div class="loshu-core-card"><p class="loshu-core-label">Driver Number</p>'
        . '<p class="loshu-core-value">' . $driver . '</p></div>'
        . '<div class="loshu-core-card"><p class="loshu-core-label">Conductor Number</p>'
        . '<p class="loshu-core-value">' . $conductor . '</p></div>'
        . '</div>';

    /* ── Present / missing / repeated summary ───────────────────── */
    $repeatedText = [];
    foreach ($repeated as $n) {
        $repeatedText[] = $n . ' (' . $counts[$n] . ' times)';
    }
    $summaryHtml = '<div class="process-card">'
        . renderValueLine('Present numbers', htmlspecialchars(implode(', ', $present) ?: 'None'))
        . renderValueLine('Missing numbers', htmlspecialchars(implode(', ', $missing) ?: 'None'))
        . renderValueLine('Repeated numbers', htmlspecialchars(implode(', ', $repeatedText) ?: 'None'))
        . '</div>';

    /* ── Lines (planes and yogs) ────────────────────────────────── */
    $lineState = [];
    foreach ($loShuData['lines'] as $key => $line) {
        $have = 0;
        foreach ($line['numbers'] as $n) {
            if ($counts[$n] > 0) {
                $have++;
            }
        }
        $lineState[$key] = $have;
    }

    $linesHtml = '';
    foreach ($lineGroups as $groupLabel => $keys) {
        $linesHtml .= '<h3 class="loshu-group-title">' . htmlspecialchars($groupLabel) . '</h3><div class="loshu-lines">';
        foreach ($keys as $key) {
            $line = $loShuData['lines'][$key];
            $have = $lineState[$key];
            if ($have === 3) {
                $class = 'is-complete';
                $status = 'Complete';
            } elseif ($have === 0) {
                $class = 'is-empty';
                $status = 'Empty';
            } else {
                $class = 'is-partial';
                $status = $have . ' of 3';
            }
            $linesHtml .= '<div class="loshu-line ' . $class . '">'
                . '<p class="loshu-line-name">' . htmlspecialchars($line['name']) . '</p>'
                . '<p class="loshu-line-numbers">' . htmlspecialchars(implode(' · ', $line['numbers'])) . '</p>'
                . '<p class="loshu-line-theme">' . htmlspecialchars($line['theme']) . '</p>'
                . '<p class="loshu-line-status">' . htmlspecialchars($status) . '</p>'
                . '</div>';
        }
        $linesHtml .= '</div>';
    }

    /* ── Readings ───────────────────────────────────────────────── */
    $coreReadingHtml = '<p><strong>Driver Number ' . $driver . '</strong></p>'
        . '<p>' . htmlspecialchars($loShuData['driver'][$driver]) . '</p>'
        . '<p><strong>Conductor Number ' . $conductor . '</strong></p>'
        . '<p>' . htmlspecialchars($loShuData['conductor'][$conductor]) . '</p>';

    $numbersReadingHtml = '';
    for ($n = 1; $n <= 9; $n++) {
        $entry = $loShuData['numbers'][$n];
        $count = $counts[$n];
        if ($count === 0) {
            $text = $entry['missing'];
            $tag = 'Missing';
            $state = 'is-missing';
        } elseif ($count === 1) {
            $text = $entry['present'];
            $tag = 'Present';
            $state = 'is-present';
        } elseif ($count === 2) {
            $text = $entry['double'];
            $tag = 'Repeated 2×';
            $state = 'is-repeated';
        } else {
            $text = $entry['excess'];
            $tag = 'Repeated ' . $count . '×';
            $state = 'is-repeated';
        }
        $numbersReadingHtml .= '<div class="loshu-reading ' . $state . '">'
            . '<div class="loshu-reading-head">'
            . '<span class="loshu-reading-title">Number ' . $n . '</span>'
            . '<span class="loshu-badge ' . $state . '">' . htmlspecialchars($tag) . '</span>'
            . '</div>'
            . '<p class="loshu-reading-theme">' . htmlspecialchars($entry['title']) . '</p>'
            . '<p>' . htmlspecialchars($text) . '</p>'
            . '</div>';
    }

    $linesReadingHtml = '';
    foreach ($lineGroups as $keys) {
        foreach ($keys as $key) {
            $line = $loShuData['lines'][$key];
            $have = $lineState[$key];
            if ($have === 3) {
                $text = $line['complete'];
                $tag = 'Complete';
                $state = 'is-present';
            } elseif ($have === 0) {
                $text = $line['missing'];
                $tag = 'Empty';
                $state = 'is-missing';
            } else {
                continue;
            }
            $linesReadingHtml .= '<div class="loshu-reading ' . $state . '">'
                . '<div class="loshu-reading-head">'
                . '<span class="loshu-reading-title">' . htmlspecialchars($line['name']) . '</span>'
                . '<span class="loshu-badge ' . $state . '">' . htmlspecialchars($tag) . '</span>'
                . '</div>'
                . '<p class="loshu-reading-theme">' . htmlspecialchars(implode(' · ', $line['numbers'])) . '</p>'
                . '<p>' . htmlspecialchars($text) . '</p>'
                . '</div>';
        }
    }
    if ($linesReadingHtml === '') {
        $linesReadingHtml = '<p>None of the planes or yogs is fully complete or fully empty in your grid. Every line holds a mixture of present and missing numbers, which points to a balanced chart with no single extreme.</p>';
    }

    return [
        'valid' => true,
        'headerText' => 'Date of Birth: ' . formatLongDate($day, $month, $year),
        'driver' => $driver,
        'conductor' => $conductor,
        'coreHtml' => $coreHtml,
        'gridHtml' => $gridHtml,
        'summaryHtml' => $summaryHtml,
        'linesHtml' => $linesHtml,
        'coreReadingHtml' => $coreReadingHtml,
        'numbersReadingHtml' => $numbersReadingHtml,
        'linesReadingHtml' => $linesReadingHtml,
    ];
};