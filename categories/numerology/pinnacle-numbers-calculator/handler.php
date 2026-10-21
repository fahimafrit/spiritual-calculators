<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   PINNACLE NUMBERS — HANDLER
   Input:  { date: "dd/mm/yyyy" }
   The birth month, day and year are each reduced, keeping the master
   numbers 11, 22 and 33 (the same reduction the Life Path Number uses).
     First Pinnacle  = month + day
     Second Pinnacle = day + year
     Third Pinnacle  = First + Second
     Fourth Pinnacle = month + year
   Each sum is reduced, keeping master numbers.
   Timing: the First Pinnacle lasts from birth to age 36 minus the Life
   Path Number (a master Life Path counts as its single digit: 11 = 2,
   22 = 4, 33 = 6). The Second and Third Pinnacles last 9 years each and
   the Fourth continues for the rest of life.
   Called through the dispatcher: POST /calculate.php?slug=pinnacle-numbers-calculator
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/engine.php';
require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/render.php';

$pinnacleData = require __DIR__ . '/readings.php';

return function (array $input) use ($pinnacleData): array {
    ['errors' => $errors, 'parsed' => $parsed] = validateBirthDate((string) ($input['date'] ?? ''));

    if (!empty($errors)) {
        return ['valid' => false, 'errorsHtml' => renderErrors($errors)];
    }

    ['day' => $day, 'month' => $month, 'year' => $year] = $parsed;

    $last = fn(array $steps): int => $steps[array_key_last($steps)];
    $esc = fn(string $text): string => htmlspecialchars($text);

    /* ── Birth components and Life Path ─────────────────────────── */
    $lifePath = computeLifePath($day, $month, $year);
    $d = $lifePath['dayFinal'];
    $m = $lifePath['monthFinal'];
    $y = $lifePath['yearFinal'];

    /* ── The four pinnacles ─────────────────────────────────────── */
    $addends = [1 => [$m, $d], 2 => [$d, $y]];
    $sums = [];
    $steps = [];
    $numbers = [];
    foreach ([1, 2] as $i) {
        $sums[$i] = array_sum($addends[$i]);
        $steps[$i] = reduceKeepingMasterWithSteps($sums[$i]);
        $numbers[$i] = $last($steps[$i]);
    }
    $addends[3] = [$numbers[1], $numbers[2]];
    $addends[4] = [$m, $y];
    foreach ([3, 4] as $i) {
        $sums[$i] = array_sum($addends[$i]);
        $steps[$i] = reduceKeepingMasterWithSteps($sums[$i]);
        $numbers[$i] = $last($steps[$i]);
    }

    /* ── Timing ─────────────────────────────────────────────────── */
    $lifePathNumber = $lifePath['number'];
    $lifePathSingle = reduceToSingleDigit($lifePathNumber);
    $firstEnd = 36 - $lifePathSingle;

    $starts = [1 => 0, 2 => $firstEnd + 1, 3 => $firstEnd + 10, 4 => $firstEnd + 19];
    $ends = [1 => $firstEnd, 2 => $firstEnd + 9, 3 => $firstEnd + 18];

    $ageText = [];
    $yearText = [];
    foreach ([1, 2, 3] as $i) {
        $ageText[$i] = 'Age ' . $starts[$i] . '–' . $ends[$i];
        $yearText[$i] = ($year + $starts[$i]) . '–' . ($year + $starts[$i + 1] - 1);
    }
    $ageText[4] = 'Age ' . $starts[4] . ' onward';
    $yearText[4] = ($year + $starts[4]) . ' onward';

    /* ── Which pinnacle the person is in today ──────────────────── */
    $now = new DateTimeImmutable('now', new DateTimeZone('UTC'));
    $age = (int) $now->format('Y') - $year;
    $nowMonth = (int) $now->format('n');
    if ($nowMonth < $month || ($nowMonth === $month && (int) $now->format('j') < $day)) {
        $age--;
    }
    $age = max(0, $age);

    if ($age <= $ends[1]) {
        $current = 1;
    } elseif ($age <= $ends[2]) {
        $current = 2;
    } elseif ($age <= $ends[3]) {
        $current = 3;
    } else {
        $current = 4;
    }

    $ordinals = [1 => 'First', 2 => 'Second', 3 => 'Third', 4 => 'Fourth'];

    /* ── Cards ──────────────────────────────────────────────────── */
    $pinnaclesHtml = '<div class="pinnacle-cards">';
    foreach ([1, 2, 3, 4] as $i) {
        $pinnaclesHtml .= '<div class="pinnacle-card' . ($i === $current ? ' is-current' : '') . '">'
            . '<p class="pinnacle-card-label">' . $ordinals[$i] . ' Pinnacle</p>'
            . '<p class="pinnacle-card-value">' . $esc(formatDisplayNumber($numbers[$i])) . '</p>'
            . '<p class="pinnacle-card-age">' . $esc($ageText[$i]) . '</p>'
            . '<p class="pinnacle-card-years">' . $esc($yearText[$i]) . '</p>'
            . ($i === $current ? '<span class="pinnacle-here">You are here</span>' : '')
            . '</div>';
    }
    $pinnaclesHtml .= '</div>'
        . '<p class="pinnacle-note">Your Life Path Number is '
        . $esc(formatDisplayNumber($lifePathNumber))
        . ', so your First Pinnacle lasts until age ' . $firstEnd . '.</p>';

    /* ── Calculation steps ──────────────────────────────────────── */
    // One labelled line: "a + b = total", then the reduction steps if the total needed reducing.
    $sumLine = function (string $label, array $parts, int $total, array $reduction): string {
        $value = implode(' + ', $parts) . ' = ' . $total;
        if (count($reduction) > 1) {
            $value .= ' <span class="process-arrow">&#8594;</span> ' . renderSteps(array_slice($reduction, 1));
        }
        return renderValueLine($label, $value);
    };
    // One birth component: the raw value, then its reduction chain if it had one.
    $componentLine = function (string $label, int $raw, array $reduction): string {
        return renderValueLine($label, count($reduction) > 1 ? renderSteps($reduction) : (string) $raw);
    };

    $lines = [
        $componentLine('Birth day', $day, $lifePath['daySteps']),
        $componentLine('Birth month', $month, $lifePath['monthSteps']),
        $componentLine('Birth year', $year, $lifePath['yearSteps']),
        $sumLine('Life Path Number', [$d, $m, $y], $lifePath['total'], $lifePath['totalSteps']),
        $sumLine('First Pinnacle (month + day)', $addends[1], $sums[1], $steps[1]),
        $sumLine('Second Pinnacle (day + year)', $addends[2], $sums[2], $steps[2]),
        $sumLine('Third Pinnacle (first + second)', $addends[3], $sums[3], $steps[3]),
        $sumLine('Fourth Pinnacle (month + year)', $addends[4], $sums[4], $steps[4]),
        renderValueLine(
            'First Pinnacle ends at age',
            ($lifePathNumber !== $lifePathSingle
                ? 'Life Path ' . $lifePathNumber . ' counts as ' . $lifePathSingle . ', so '
                : '')
            . '36 − ' . $lifePathSingle . ' = ' . $firstEnd
        ),
    ];
    $processHtml = '<div class="process-card">' . implode('', $lines) . '</div>';

    /* ── Readings: the four pinnacles in order ──────────────────── */
    $renderList = function (string $title, array $items) use ($esc): string {
        return '<p class="pinnacle-block-title">' . $esc($title) . '</p>'
            . '<ul class="pinnacle-list">'
            . implode('', array_map(fn(string $item): string => '<li>' . $esc($item) . '</li>', $items))
            . '</ul>';
    };

    $readingsHtml = '';
    foreach ([1, 2, 3, 4] as $i) {
        $stage = $pinnacleData['stages'][$i];
        $reading = $pinnacleData['readings'][$numbers[$i]][$i] ?? null;
        $isCurrent = $i === $current;

        if ($isCurrent) {
            $statusClass = 'is-here';
            $statusText = 'You are here';
        } elseif ($i < $current) {
            $statusClass = 'is-done';
            $statusText = 'Completed';
        } else {
            $statusClass = 'is-ahead';
            $statusText = 'Still ahead';
        }

        $readingsHtml .= '<div class="pinnacle-reading' . ($isCurrent ? ' is-current' : '') . '">'
            . '<div class="pinnacle-reading-head">'
            . '<span class="pinnacle-reading-title">' . $ordinals[$i] . ' Pinnacle</span>'
            . '<span class="pinnacle-badges">'
            . '<span class="pinnacle-badge ' . $statusClass . '">' . $statusText . '</span>'
            . '<span class="pinnacle-badge">Number ' . $esc(formatDisplayNumber($numbers[$i])) . '</span>'
            . '</span>'
            . '</div>'
            . '<p class="pinnacle-reading-theme">' . $esc($stage['name'] . ' · ' . $ageText[$i] . ' · ' . $yearText[$i]) . '</p>'
            . '<p class="pinnacle-reading-about">' . $esc($stage['about']) . '</p>';

        if ($reading !== null) {
            $readingsHtml .= '<h3 class="pinnacle-headline">' . $esc($reading['headline']) . '</h3>'
                . '<p>' . $esc($reading['story']) . '</p>'
                . $renderList('Strengths to draw on', $reading['strengths'])
                . $renderList('What to watch for', $reading['watch'])
                . $renderList('How to make the most of it', $reading['guidance']);
        }

        // For the pinnacle the person is in now: what comes next.
        if ($isCurrent) {
            if ($i < 4) {
                $nextStart = $starts[$i + 1];
                $inYears = max(1, $nextStart - $age);
                $nextMeta = $pinnacleData['numbers'][$numbers[$i + 1]] ?? null;
                $nowText = 'Your ' . $ordinals[$i + 1] . ' Pinnacle begins at age ' . $nextStart
                    . ', in about ' . $inYears . ($inYears === 1 ? ' year' : ' years')
                    . ' (around ' . ($year + $nextStart) . ').'
                    . ($nextMeta !== null
                        ? ' It carries the energy of ' . formatDisplayNumber($numbers[$i + 1]) . ' and brings ' . $nextMeta['arrival'] . '.'
                        : '');
            } else {
                $nowText = 'The Fourth Pinnacle is your final cycle, and it carries on from here. Everything it offers is yours to shape.';
            }
            $readingsHtml .= '<div class="pinnacle-now"><p class="pinnacle-block-title">Right now</p><p>' . $esc($nowText) . '</p></div>';
        }

        $readingsHtml .= '</div>';
    }

    /* ── Your Pinnacles Together ────────────────────────────────── */
    $meta = $pinnacleData['numbers'];
    $joinList = function (array $items): string {
        if (count($items) <= 1) {
            return implode('', $items);
        }
        return implode(', ', array_slice($items, 0, -1)) . ' and ' . $items[array_key_last($items)];
    };

    $keywords = array_map(fn(int $n): string => $meta[$n]['keyword'] ?? '', $numbers);
    $togetherHtml = '<p>Your four chapters move through ' . $esc($keywords[1]) . ', then ' . $esc($keywords[2])
        . ', then ' . $esc($keywords[3]) . ', and finally ' . $esc($keywords[4]) . '.</p>';

    // A number that appears in more than one pinnacle.
    $positionsByNumber = [];
    foreach ($numbers as $i => $n) {
        $positionsByNumber[$n][] = $i;
    }
    foreach ($positionsByNumber as $n => $positions) {
        if (count($positions) < 2) {
            continue;
        }
        $names = array_map(fn(int $i): string => $ordinals[$i], $positions);
        $togetherHtml .= '<p>The ' . $esc(formatDisplayNumber($n)) . ' appears in your ' . $joinList($names) . ' Pinnacles. '
            . (count($positions) === 2
                ? 'When a number returns, its theme of ' . $esc($meta[$n]['keyword'] ?? '') . ' comes back for a second look, usually with more experience behind you than the first time.'
                : 'When a number keeps returning, its theme of ' . $esc($meta[$n]['keyword'] ?? '') . ' is one of the central threads of your life, met again with more experience each time.')
            . '</p>';
    }

    // Master numbers among the four pinnacles.
    $masterPositions = [];
    $masterDisplays = [];
    foreach ($numbers as $i => $n) {
        if (in_array($n, [11, 22, 33], true)) {
            $masterPositions[] = $ordinals[$i];
            $masterDisplays[$n] = formatDisplayNumber($n);
        }
    }
    if (!empty($masterPositions)) {
        $togetherHtml .= '<p>Your ' . $joinList($masterPositions) . (count($masterPositions) === 1 ? ' Pinnacle carries' : ' Pinnacles carry')
            . ' a master number (' . $esc(implode(', ', array_values($masterDisplays))) . '). '
            . 'Master chapters offer more potential and more pressure than usual. Each one also holds the steadier energy of its single-digit root, '
            . 'which you can lean on whenever the intensity feels like too much.</p>';
    }

    return [
        'valid' => true,
        'headerText' => 'Date of Birth: ' . formatLongDate($day, $month, $year),
        'pinnaclesHtml' => $pinnaclesHtml,
        'processHtml' => $processHtml,
        'readingsHtml' => $readingsHtml,
        'togetherHtml' => $togetherHtml,
    ];
};