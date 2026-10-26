<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   WEDDING DATE NUMEROLOGY — HANDLER
   Input:  { wedding: "dd/mm/yyyy", date1?: "dd/mm/yyyy", date2?: "dd/mm/yyyy" }
   The wedding date is reduced exactly like a Life Path Number (day,
   month and year each reduced keeping the master numbers 11, 22 and 33,
   then added and reduced again). The wedding date may be in the past or
   the future.
   When both partners' birth dates are given, each gets a Life Path
   Number, the two are added into the Marriage Number, and the wedding
   date number is matched against each Life Path (master numbers match
   through their root digit: 11 = 2, 22 = 4, 33 = 6).
   Every other day of the wedding month is also numbered, so the couple
   can see which dates in that month suit them best.
   Called through the dispatcher: POST /calculate.php?slug=wedding-date-numerology
   ════════════════════════════════════════════════════════════════════ */

require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/engine.php';
require_once SPIRITUAL_ROOT . '/categories/numerology/_shared/render.php';

$weddingData = require __DIR__ . '/readings.php';

const WDN_YEAR_MIN = 1900;
const WDN_YEAR_MAX = 2200;

/** Fit tier (key and label) for a 0-100 score. @return array{0:string,1:string} */
function wdnTier(int $score): array
{
    if ($score >= 85) return ['excellent', 'Excellent Fit'];
    if ($score >= 75) return ['strong', 'Strong Fit'];
    if ($score >= 60) return ['moderate', 'Moderate Fit'];
    return ['care', 'Needs Care'];
}

/** Pair key for the fit table: both numbers by root digit, lowest first ("3-5"). */
function wdnPairKey(int $a, int $b): string
{
    $roots = [reduceToSingleDigit($a), reduceToSingleDigit($b)];
    sort($roots);
    return $roots[0] . '-' . $roots[1];
}

/** "6th, 15th and 24th" style list. @param int[] $days */
function wdnDayList(array $days): string
{
    $suffix = function (int $n): string {
        if ($n % 100 >= 11 && $n % 100 <= 13) return 'th';
        return [1 => 'st', 2 => 'nd', 3 => 'rd'][$n % 10] ?? 'th';
    };
    $items = array_map(fn(int $d): string => $d . $suffix($d), $days);
    if (count($items) <= 1) return implode('', $items);
    return implode(', ', array_slice($items, 0, -1)) . ' and ' . $items[array_key_last($items)];
}

/**
 * The calculation lines for one date: day, month and year each reduced
 * (keeping master numbers), then added and reduced again.
 * @param array $lp   result of computeLifePath()
 * @param string[] $labels three labels: day, month, year
 * @return string[]
 */
function wdnProcessLines(array $lp, int $day, int $month, int $year, array $labels, string $sumLabel): array
{
    $component = function (string $label, int $raw, array $steps): string {
        return renderValueLine($label, count($steps) > 1 ? renderSteps($steps) : (string) $raw);
    };
    $sumValue = implode(' + ', [$lp['dayFinal'], $lp['monthFinal'], $lp['yearFinal']]) . ' = ' . $lp['total'];
    if (count($lp['totalSteps']) > 1) {
        $sumValue .= PROCESS_ARROW . renderSteps(array_slice($lp['totalSteps'], 1));
    }
    return [
        $component($labels[0], $day, $lp['daySteps']),
        $component($labels[1], $month, $lp['monthSteps']),
        $component($labels[2], $year, $lp['yearSteps']),
        renderValueLine($sumLabel, $sumValue),
    ];
}

/** One interpretation block (headline, story and optional lists) as HTML. */
function wdnRenderReading(?array $reading): string
{
    if (!$reading) {
        return '';
    }
    $esc = fn(string $text): string => htmlspecialchars($text);
    $html = '';
    if (!empty($reading['headline'])) {
        $html .= '<h3 class="wedding-headline">' . $esc((string) $reading['headline']) . '</h3>';
    }
    if (!empty($reading['story'])) {
        $html .= '<p>' . $esc((string) $reading['story']) . '</p>';
    }
    $blocks = [
        'strengths' => 'What this date offers',
        'watch' => 'What to watch for',
        'guidance' => 'How to make the most of it',
    ];
    foreach ($blocks as $key => $title) {
        if (!empty($reading[$key])) {
            $html .= '<p class="wedding-block-title">' . $esc($title) . '</p><ul class="wedding-list">'
                . implode('', array_map(fn(string $item): string => '<li>' . $esc($item) . '</li>', $reading[$key]))
                . '</ul>';
        }
    }
    return $html;
}

return function (array $input) use ($weddingData): array {
    /* ── Validate: wedding date (any real date), optional birth dates ── */
    $errors = [];

    $weddingParsed = parseDdMmYyyy(trim((string) ($input['wedding'] ?? '')));
    if (!isValidCalendarDate($weddingParsed)) {
        $errors[] = 'Wedding date is not valid. Use dd/mm/yyyy.';
        $weddingParsed = null;
    } elseif ($weddingParsed['year'] < WDN_YEAR_MIN || $weddingParsed['year'] > WDN_YEAR_MAX) {
        $errors[] = 'Wedding date must be between ' . WDN_YEAR_MIN . ' and ' . WDN_YEAR_MAX . '.';
        $weddingParsed = null;
    }

    $raw1 = trim((string) ($input['date1'] ?? ''));
    $raw2 = trim((string) ($input['date2'] ?? ''));
    $birth = [];
    if ($raw1 !== '' || $raw2 !== '') {
        if ($raw1 === '' || $raw2 === '') {
            $errors[] = "Enter both partners' birth dates, or leave both empty.";
        } else {
            foreach ([1 => $raw1, 2 => $raw2] as $n => $raw) {
                $check = validateBirthDate($raw);
                foreach ($check['errors'] as $message) {
                    $errors[] = 'Partner ' . $n . ': ' . $message;
                }
                $birth[$n] = $check['parsed'];
            }
        }
    }

    if (!empty($errors)) {
        return ['valid' => false, 'errorsHtml' => renderErrors($errors)];
    }

    ['day' => $day, 'month' => $month, 'year' => $year] = $weddingParsed;
    $hasCouple = count($birth) === 2;

    /* ── The wedding date number ───────────────────────────────────── */
    $date = computeLifePath($day, $month, $year);
    $weddingNumber = $date['number'];

    $weekday = (new DateTimeImmutable(sprintf('%04d-%02d-%02d', $year, $month, $day)))->format('l');
    $dateText = $weekday . ', ' . formatLongDate($day, $month, $year);

    $processLines = [renderValueLine('Wedding date', htmlspecialchars(formatLongDate($day, $month, $year)))];
    $processLines = array_merge($processLines, wdnProcessLines($date, $day, $month, $year, ['Wedding day', 'Wedding month', 'Wedding year'], 'Sum'));
    $processLines[] = renderFinalLine('Wedding Date Number: ' . formatDisplayNumber($weddingNumber));
    $processHtml = '<div class="process-card">' . implode('', $processLines) . '</div>';

    /* ── The couple: Life Paths, Marriage Number, fit ──────────────── */
    $couple = null;
    $coupleProcessHtml = '';
    $fitNotesHtml = '';
    $partnerScores = [];

    if ($hasCouple) {
        $people = [];
        foreach ([1, 2] as $n) {
            ['day' => $bd, 'month' => $bm, 'year' => $by] = $birth[$n];
            $lifePath = computeLifePath($bd, $bm, $by);
            $lines = wdnProcessLines($lifePath, $bd, $bm, $by, ['Birth day', 'Birth month', 'Birth year'], 'Sum');
            $lines[] = renderFinalLine('Life Path Number: ' . formatDisplayNumber($lifePath['number']));
            $coupleProcessHtml .= '<div class="process-card wedding-process-gap">'
                . '<p class="process-line"><span class="process-label">Partner ' . $n . ': ' . htmlspecialchars(formatLongDate($bd, $bm, $by)) . '</span></p>'
                . implode('', $lines) . '</div>';

            $score = (int) ($weddingData['fit'][wdnPairKey($weddingNumber, $lifePath['number'])] ?? 0);
            [$tierKey, $tierLabel] = wdnTier($score);
            $partnerScores[$n] = $score;
            $people[$n] = [
                'number' => $lifePath['number'],
                'numValue' => formatDisplayNumber($lifePath['number']),
                'dateText' => formatLongDate($bd, $bm, $by),
                'score' => $score,
                'tier' => $tierKey,
                'tierLabel' => $tierLabel,
            ];
        }

        $marriageSum = $people[1]['number'] + $people[2]['number'];
        $marriageSteps = reduceKeepingMasterWithSteps($marriageSum);
        $marriageNumber = (int) end($marriageSteps);
        $coupleProcessHtml .= '<div class="process-card wedding-process-gap">'
            . renderValueLine(
                'Marriage Number (Life Path 1 + Life Path 2)',
                $people[1]['number'] . ' + ' . $people[2]['number'] . ' = ' . $marriageSum
                    . (count($marriageSteps) > 1 ? PROCESS_ARROW . renderSteps(array_slice($marriageSteps, 1)) : '')
            )
            . renderFinalLine('Marriage Number: ' . formatDisplayNumber($marriageNumber))
            . '</div>';

        $overall = (int) round(($partnerScores[1] + $partnerScores[2]) / 2);
        [$overallTier, $overallLabel] = wdnTier($overall);
        $couple = [
            'person1' => $people[1],
            'person2' => $people[2],
            'marriageValue' => formatDisplayNumber($marriageNumber),
            'overall' => $overall,
            'overallTier' => $overallTier,
            'overallLabel' => $overallLabel,
        ];

        // Optional interpretation notes, written separately from the calculation.
        foreach ([1, 2] as $n) {
            $note = $weddingData['fits'][wdnPairKey($weddingNumber, $people[$n]['number'])] ?? null;
            if (is_array($note) && !empty($note['text'])) {
                $fitNotesHtml .= '<p><strong>Partner ' . $n . ':</strong> ' . htmlspecialchars((string) $note['text']) . '</p>';
            }
        }
        $marriageReading = wdnRenderReading($weddingData['marriage'][$marriageNumber] ?? null);
        if ($marriageReading !== '') {
            $fitNotesHtml .= '<hr class="section-divider" /><p class="wedding-block-title">Your Marriage Number: '
                . htmlspecialchars(formatDisplayNumber($marriageNumber)) . '</p>' . $marriageReading;
        }
    }

    /* ── Interpretation of the date number ─────────────────────────── */
    $readingsHtml = wdnRenderReading($weddingData['readings'][$weddingNumber] ?? null);
    if ($fitNotesHtml !== '') {
        $readingsHtml .= ($readingsHtml !== '' ? '<hr class="section-divider" />' : '') . $fitNotesHtml;
    }

    /* ── Every day of the wedding month ────────────────────────────── */
    $daysInMonth = (int) (new DateTimeImmutable(sprintf('%04d-%02d-01', $year, $month)))->format('t');
    $monthLabel = MONTH_NAMES[$month - 1] . ' ' . $year;
    $chips = '';
    $dayScores = [];
    for ($d = 1; $d <= $daysInMonth; $d++) {
        $number = computeLifePath($d, $month, $year)['number'];
        $classes = 'wedding-day' . ($d === $day ? ' is-chosen' : '');
        $title = (new DateTimeImmutable(sprintf('%04d-%02d-%02d', $year, $month, $d)))->format('D') . ' ' . $d . ' ' . MONTH_NAMES[$month - 1] . ': number ' . formatDisplayNumber($number);

        if ($hasCouple) {
            $s1 = (int) ($weddingData['fit'][wdnPairKey($number, $people[1]['number'])] ?? 0);
            $s2 = (int) ($weddingData['fit'][wdnPairKey($number, $people[2]['number'])] ?? 0);
            $dayScore = (int) round(($s1 + $s2) / 2);
            $dayScores[$d] = $dayScore;
            [$tierKey, $tierLabel] = wdnTier($dayScore);
            $classes .= ' tier-' . $tierKey;
            $title .= ', ' . $tierLabel;
        }

        $chips .= '<li class="' . $classes . '" title="' . htmlspecialchars($title) . '">'
            . '<span class="wedding-day-num">' . $d . '</span>'
            . '<span class="wedding-day-val">' . htmlspecialchars(formatDisplayNumber($number)) . '</span></li>';
    }
    $monthHtml = '<ul class="wedding-days">' . $chips . '</ul>'
        . '<p class="wedding-month-note">Each box shows the day of the month and, below it, that date’s number.'
        . ($hasCouple ? ' Colour shows how well each date fits the two of you.' : '') . '</p>';

    if ($hasCouple) {
        $monthHtml .= '<ul class="wedding-legend">'
            . '<li><span class="wedding-swatch tier-excellent"></span>Excellent</li>'
            . '<li><span class="wedding-swatch tier-strong"></span>Strong</li>'
            . '<li><span class="wedding-swatch tier-moderate"></span>Moderate</li>'
            . '<li><span class="wedding-swatch tier-care"></span>Needs care</li></ul>';

        $best = max($dayScores);
        $bestDays = array_keys(array_filter($dayScores, fn(int $s): bool => $s === $best));
        $monthHtml .= '<p class="wedding-month-note"><strong>Best-fitting dates in ' . htmlspecialchars($monthLabel) . ':</strong> '
            . htmlspecialchars(wdnDayList($bestDays)) . '.</p>';
    }

    return [
        'valid' => true,
        'headerText' => 'Wedding Date: ' . $dateText,
        'numValue' => formatDisplayNumber($weddingNumber),
        'dateText' => $dateText,
        'processHtml' => $processHtml,
        'hasCouple' => $hasCouple,
        'couple' => $couple,
        'coupleProcessHtml' => $coupleProcessHtml,
        'readingsHtml' => $readingsHtml,
        'monthTitle' => 'Your Wedding Month: ' . $monthLabel,
        'monthHtml' => $monthHtml,
    ];
};