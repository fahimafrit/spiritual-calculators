<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   CHALLENGE NUMBERS — HANDLER
   Input:  { date: "dd/mm/yyyy" }
   The birth month, day and year are each reduced to a single digit
   (11 becomes 2, 22 becomes 4, 33 becomes 6), because Challenge Numbers
   are differences and always fall between 0 and 8.
     First Challenge  = |month − day|
     Second Challenge = |day − year|
     Third Challenge  = |first − second|   (the Main Challenge)
     Fourth Challenge = |month − year|
   Timing follows the Pinnacle periods: the first challenge lasts from
   birth to age 36 minus the Life Path Number (a master Life Path counts
   as its single digit). The second and third last 9 years each and the
   fourth continues for the rest of life.
   Called through the dispatcher: POST /calculate.php?slug=challenge-numbers-calculator
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/engine.php';
require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/render.php';

$challengeData = require __DIR__ . '/readings.php';

return function (array $input) use ($challengeData): array {
    ['errors' => $errors, 'parsed' => $parsed] = validateBirthDate((string) ($input['date'] ?? ''));

    if (!empty($errors)) {
        return ['valid' => false, 'errorsHtml' => renderErrors($errors)];
    }

    ['day' => $day, 'month' => $month, 'year' => $year] = $parsed;

    $esc = fn(string $text): string => htmlspecialchars($text);

    /* ── Birth components (single digits) and Life Path ─────────── */
    $lifePath = computeLifePath($day, $month, $year);

    // Reduction chain ending in a single digit: the keep-master chain, extended if it stopped on 11/22/33.
    $toSingle = function (array $steps): array {
        $lastValue = $steps[array_key_last($steps)];
        if ($lastValue > 9) {
            $steps[] = reduceToSingleDigit($lastValue);
        }
        return $steps;
    };
    $daySteps = $toSingle($lifePath['daySteps']);
    $monthSteps = $toSingle($lifePath['monthSteps']);
    $yearSteps = $toSingle($lifePath['yearSteps']);
    $d = $daySteps[array_key_last($daySteps)];
    $m = $monthSteps[array_key_last($monthSteps)];
    $y = $yearSteps[array_key_last($yearSteps)];

    /* ── The four challenges ────────────────────────────────────── */
    $pairs = [1 => [$m, $d], 2 => [$d, $y]];
    $numbers = [];
    foreach ([1, 2] as $i) {
        $numbers[$i] = abs($pairs[$i][0] - $pairs[$i][1]);
    }
    $pairs[3] = [$numbers[1], $numbers[2]];
    $numbers[3] = abs($numbers[1] - $numbers[2]);
    $pairs[4] = [$m, $y];
    $numbers[4] = abs($m - $y);

    /* ── Timing (same periods as the Pinnacles) ─────────────────── */
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

    /* ── Which challenge the person is in today ─────────────────── */
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
    $challengesHtml = '<div class="challenge-cards">';
    foreach ([1, 2, 3, 4] as $i) {
        $challengesHtml .= '<div class="challenge-card' . ($i === $current ? ' is-current' : '') . '">'
            . '<p class="challenge-card-label">' . $ordinals[$i] . ' Challenge</p>'
            . '<p class="challenge-card-value">' . $numbers[$i] . '</p>'
            . '<p class="challenge-card-age">' . $esc($ageText[$i]) . '</p>'
            . '<p class="challenge-card-years">' . $esc($yearText[$i]) . '</p>'
            . ($i === 3 ? '<span class="challenge-main">Main Challenge</span>' : '')
            . ($i === $current ? '<span class="challenge-here">You are here</span>' : '')
            . '</div>';
    }
    $challengesHtml .= '</div>'
        . '<p class="challenge-note">Your Life Path Number is '
        . $esc(formatDisplayNumber($lifePathNumber))
        . ', so your First Challenge lasts until age ' . $firstEnd . '.</p>';

    /* ── Calculation steps ──────────────────────────────────────── */
    // One birth component: the raw value, then its reduction chain if it had one.
    $componentLine = function (string $label, int $raw, array $reduction): string {
        return renderValueLine($label, count($reduction) > 1 ? renderSteps($reduction) : (string) $raw);
    };
    // One difference, written larger − smaller.
    $differenceLine = function (string $label, array $pair, int $result): string {
        $high = max($pair);
        $low = min($pair);
        return renderValueLine($label, $high . ' − ' . $low . ' = ' . $result);
    };

    $lines = [
        $componentLine('Birth day', $day, $daySteps),
        $componentLine('Birth month', $month, $monthSteps),
        $componentLine('Birth year', $year, $yearSteps),
        $differenceLine('First Challenge (difference of month and day)', $pairs[1], $numbers[1]),
        $differenceLine('Second Challenge (difference of day and year)', $pairs[2], $numbers[2]),
        $differenceLine('Third Challenge (difference of first and second)', $pairs[3], $numbers[3]),
        $differenceLine('Fourth Challenge (difference of month and year)', $pairs[4], $numbers[4]),
        renderValueLine(
            'First Challenge ends at age',
            ($lifePathNumber !== $lifePathSingle
                ? 'Life Path ' . $lifePathNumber . ' counts as ' . $lifePathSingle . ', so '
                : '')
            . '36 − ' . $lifePathSingle . ' = ' . $firstEnd
        ),
    ];
    $processHtml = '<div class="process-card">' . implode('', $lines) . '</div>';

    /* ── Readings: the four challenges in order ─────────────────── */
    // Optional list blocks of a reading, shown only when the readings file provides them.
    $listBlocks = [
        'shows' => 'How it can show up',
        'work' => 'How to work with it',
        'gift' => 'The strength it builds',
    ];

    $readingsHtml = '';
    foreach ([1, 2, 3, 4] as $i) {
        $stage = $challengeData['stages'][$i];
        $reading = $challengeData['readings'][$numbers[$i]][$i] ?? null;
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

        $readingsHtml .= '<div class="challenge-reading' . ($isCurrent ? ' is-current' : '') . '">'
            . '<div class="challenge-reading-head">'
            . '<span class="challenge-reading-title">' . $ordinals[$i] . ' Challenge' . ($i === 3 ? ' · Main' : '') . '</span>'
            . '<span class="challenge-badges">'
            . '<span class="challenge-badge ' . $statusClass . '">' . $statusText . '</span>'
            . '<span class="challenge-badge">Number ' . $numbers[$i] . '</span>'
            . '</span>'
            . '</div>'
            . '<p class="challenge-reading-theme">' . $esc($stage['name'] . ' · ' . $ageText[$i] . ' · ' . $yearText[$i]) . '</p>'
            . '<p class="challenge-reading-about">' . $esc($stage['about']) . '</p>';

        if ($reading !== null) {
            $readingsHtml .= '<h3 class="challenge-headline">' . $esc((string) ($reading['headline'] ?? '')) . '</h3>'
                . '<p>' . $esc((string) ($reading['story'] ?? '')) . '</p>';
            foreach ($listBlocks as $key => $title) {
                if (!empty($reading[$key])) {
                    $readingsHtml .= '<p class="challenge-block-title">' . $esc($title) . '</p>'
                        . '<ul class="challenge-list">'
                        . implode('', array_map(fn(string $item): string => '<li>' . $esc($item) . '</li>', $reading[$key]))
                        . '</ul>';
                }
            }
        }

        // For the challenge the person is in now: what comes next.
        if ($isCurrent) {
            if ($i < 4) {
                $nextStart = $starts[$i + 1];
                $inYears = max(1, $nextStart - $age);
                $nextKeyword = $challengeData['numbers'][$numbers[$i + 1]]['keyword'] ?? null;
                $nowText = 'Your ' . $ordinals[$i + 1] . ' Challenge begins at age ' . $nextStart
                    . ', in about ' . $inYears . ($inYears === 1 ? ' year' : ' years')
                    . ' (around ' . ($year + $nextStart) . ').'
                    . ($nextKeyword !== null
                        ? ' It centres on ' . $nextKeyword . ($i + 1 === 3 ? ' and is your Main Challenge.' : '.')
                        : '');
            } else {
                $nowText = 'The Fourth Challenge is your final chapter, and it carries on from here. Every step you take towards it is a step towards the wisdom it offers.';
            }
            $readingsHtml .= '<div class="challenge-now"><p class="challenge-block-title">Right now</p><p>' . $esc($nowText) . '</p></div>';
        }

        $readingsHtml .= '</div>';
    }

    /* ── Your Challenges Together ───────────────────────────────── */
    $meta = $challengeData['numbers'];
    $joinList = function (array $items): string {
        if (count($items) <= 1) {
            return implode('', $items);
        }
        return implode(', ', array_slice($items, 0, -1)) . ' and ' . $items[array_key_last($items)];
    };

    $keywords = array_map(fn(int $n): string => $meta[$n]['keyword'] ?? '', $numbers);
    $togetherHtml = '<p>Your four challenges move through ' . $esc($keywords[1]) . ', then ' . $esc($keywords[2])
        . ', then ' . $esc($keywords[3]) . ', and finally ' . $esc($keywords[4]) . '.</p>';

    // The Main Challenge: the thread to watch.
    $togetherHtml .= '<p>Your Main Challenge is ' . $numbers[3] . ', so the thread most worth watching in your life is '
        . $esc($meta[$numbers[3]]['main'] ?? '') . '.</p>';

    // A number that appears in more than one challenge.
    $positionsByNumber = [];
    foreach ($numbers as $i => $n) {
        $positionsByNumber[$n][] = $i;
    }
    foreach ($positionsByNumber as $n => $positions) {
        if (count($positions) < 2) {
            continue;
        }
        $names = array_map(fn(int $i): string => $ordinals[$i], $positions);
        $togetherHtml .= '<p>The ' . $n . ' appears in your ' . $joinList($names) . ' Challenges. '
            . (count($positions) === 2
                ? 'When a challenge returns, its theme of ' . $esc($meta[$n]['keyword'] ?? '') . ' comes back for a second look, usually with more experience behind you than the first time.'
                : 'When a challenge keeps returning, its theme of ' . $esc($meta[$n]['keyword'] ?? '') . ' is one of the central threads of your life, met again with more experience each time.')
            . '</p>';
    }

    // A challenge of 0.
    if (in_array(0, $numbers, true)) {
        $togetherHtml .= '<p>A 0 is not a free pass. It carries no fixed lesson of its own, which means the lesson is to choose one: to decide what you stand for, and to keep deciding it as life changes.</p>';
    }

    $togetherHtml .= '<p>None of these challenges is a sentence. Each one marks a place where you can grow, and the people who work with their challenges tend to turn them into their greatest strengths.</p>';

    return [
        'valid' => true,
        'headerText' => 'Date of Birth: ' . formatLongDate($day, $month, $year),
        'challengesHtml' => $challengesHtml,
        'processHtml' => $processHtml,
        'readingsHtml' => $readingsHtml,
        'togetherHtml' => $togetherHtml,
    ];
};