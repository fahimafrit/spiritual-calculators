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
    $masters = [11, 22, 33];

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

    /* ── Life in Four Chapters: an overview built from the numbers ── */
    $join = function (array $items): string {
        $count = count($items);
        if ($count <= 1) {
            return implode('', $items);
        }
        return implode(', ', array_slice($items, 0, -1)) . ' and ' . $items[$count - 1];
    };
    $keyword = fn(int $i): string => $pinnacleData['keywords'][$numbers[$i]];
    $shown = fn(int $i): string => formatDisplayNumber($numbers[$i]);

    $overview = 'Your four pinnacles begin with ' . $keyword(1) . ' (' . $shown(1) . '), move through '
        . $keyword(2) . ' (' . $shown(2) . ') and ' . $keyword(3) . ' (' . $shown(3)
        . '), and settle into ' . $keyword(4) . ' (' . $shown(4) . ').';

    $turns = '';
    foreach ([1, 2, 3] as $i) {
        $when = 'Age ' . $starts[$i + 1] . ' (' . ($year + $starts[$i + 1]) . '): ';
        if ($numbers[$i] === $numbers[$i + 1]) {
            $turns .= '<li>' . $esc($when . $keyword($i) . ' carries on into a new chapter of life.') . '</li>';
        } else {
            $turns .= '<li>' . $esc($when . 'from ' . $keyword($i) . ' to ' . $keyword($i + 1) . '.') . '</li>';
        }
    }

    // Numbers that return, listed in order of first appearance.
    $where = [];
    foreach ([1, 2, 3, 4] as $i) {
        $where[$numbers[$i]][] = $ordinals[$i];
    }
    $returns = '';
    foreach ($where as $number => $stages) {
        if (count($stages) >= 2) {
            $returns .= '<p>' . $esc(
                'Number ' . formatDisplayNumber($number) . ' appears in your ' . $join($stages)
                . ' Pinnacles, so the themes of ' . $pinnacleData['keywords'][$number]
                . ' run through your life rather than belonging to a single chapter.'
            ) . '</p>';
        }
    }

    $masterNotes = '';
    $masterAt = array_values(array_filter([1, 2, 3, 4], fn(int $i): bool => in_array($numbers[$i], $masters, true)));
    if (count($masterAt) === 1) {
        $i = $masterAt[0];
        $masterNotes = '<p>' . $esc(
            'Your ' . $ordinals[$i] . ' Pinnacle carries the master number ' . $shown($i)
            . '. Master numbers bring heightened potential and heightened pressure, and the '
            . reduceToSingleDigit($numbers[$i])
            . ' always remains available as a steadier way to express the same energy.'
        ) . '</p>';
    } elseif (count($masterAt) > 1) {
        $masterNotes = '<p>' . $esc(
            'Your ' . $join(array_map(fn(int $i): string => $ordinals[$i], $masterAt))
            . ' Pinnacles carry master numbers (' . $join(array_map($shown, $masterAt))
            . '). Master numbers bring heightened potential and heightened pressure, and the single digits behind them ('
            . $join(array_map(fn(int $i): string => (string) reduceToSingleDigit($numbers[$i]), $masterAt))
            . ') always remain available as a steadier way to express the same energy.'
        ) . '</p>';
    }

    if ($current < 4) {
        $yearsLeft = $starts[$current + 1] - $age;
        $now_ = 'Right now you are in your ' . $ordinals[$current] . ' Pinnacle, the '
            . $pinnacleData['stages'][$current]['name'] . ', at age ' . $age
            . '. Your next chapter begins at age ' . $starts[$current + 1] . ' in '
            . ($year + $starts[$current + 1]) . ', about ' . $yearsLeft
            . ($yearsLeft === 1 ? ' year' : ' years') . ' from now.';
    } else {
        $now_ = 'Right now you are in your Fourth Pinnacle, the ' . $pinnacleData['stages'][4]['name']
            . ', at age ' . $age . '. It continues for the rest of your life.';
    }

    $journeyHtml = '<p>' . $esc($overview) . '</p>'
        . '<p>' . $esc('Each change is usually felt gradually, in the months around your birthday, rather than overnight.') . '</p>'
        . '<ul class="pinnacle-turns">' . $turns . '</ul>'
        . $returns
        . $masterNotes
        . '<p class="pinnacle-now">' . $esc($now_) . '</p>';

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
    $areas = [
        'work' => 'Work and money',
        'love' => 'Love and relationships',
        'inner' => 'Inner life',
    ];
    $points = [
        'opportunity' => ['is-opportunity', 'What opens up'],
        'watch' => ['is-watch', 'What to watch for'],
        'advice' => ['is-advice', 'How to make the most of it'],
    ];

    $readingsHtml = '';
    foreach ([1, 2, 3, 4] as $i) {
        $stage = $pinnacleData['stages'][$i];
        $entry = $pinnacleData['readings'][$i][$numbers[$i]] ?? null;
        $isCurrent = $i === $current;

        $readingsHtml .= '<div class="pinnacle-reading' . ($isCurrent ? ' is-current' : '') . '">'
            . '<div class="pinnacle-reading-head">'
            . '<span class="pinnacle-reading-title">' . $ordinals[$i] . ' Pinnacle</span>'
            . '<span class="pinnacle-badges">'
            . ($isCurrent ? '<span class="pinnacle-badge is-here">You are here</span>' : '')
            . '<span class="pinnacle-badge">Number ' . $esc(formatDisplayNumber($numbers[$i])) . '</span>'
            . '</span>'
            . '</div>'
            . '<p class="pinnacle-reading-theme">' . $esc($stage['name'] . ' · ' . $ageText[$i] . ' · ' . $yearText[$i]) . '</p>'
            . '<p class="pinnacle-reading-intro">' . $esc($stage['intro']) . '</p>';

        if ($entry !== null) {
            $readingsHtml .= '<p class="pinnacle-reading-headline">' . $esc($entry['headline']) . '</p>'
                . '<p class="pinnacle-reading-story">' . $esc($entry['story']) . '</p>'
                . '<div class="pinnacle-areas">';
            foreach ($areas as $field => $label) {
                $readingsHtml .= '<div class="pinnacle-area">'
                    . '<p class="pinnacle-area-label">' . $esc($label) . '</p>'
                    . '<p class="pinnacle-area-text">' . $esc($entry[$field]) . '</p>'
                    . '</div>';
            }
            $readingsHtml .= '</div><div class="pinnacle-points">';
            foreach ($points as $field => [$class, $label]) {
                $readingsHtml .= '<p class="pinnacle-point ' . $class . '">'
                    . '<span class="pinnacle-point-label">' . $esc($label) . '</span>'
                    . '<span class="pinnacle-point-text">' . $esc($entry[$field]) . '</span>'
                    . '</p>';
            }
            $readingsHtml .= '</div>';
        }
        $readingsHtml .= '</div>';
    }

    return [
        'valid' => true,
        'headerText' => 'Date of Birth: ' . formatLongDate($day, $month, $year),
        'pinnaclesHtml' => $pinnaclesHtml,
        'journeyHtml' => $journeyHtml,
        'processHtml' => $processHtml,
        'readingsHtml' => $readingsHtml,
    ];
};