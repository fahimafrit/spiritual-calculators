<?php
declare(strict_types=1);

/* ════════════════════════════════════════════════════════════════════
   NUMEROLOGY CORE — RESULT RENDERING (PHP)
   The HTML fragments every numerology calculator returns: error
   messages, calculation-process lines, and interpretation blocks.
   This file owns ONLY presentation markup — the math lives in
   engine.php, the interpretation text lives in each calculator's own
   readings.php. Never included directly from a browser request.
   ════════════════════════════════════════════════════════════════════ */

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

const PROCESS_ARROW = ' <span class="process-arrow">&#8594;</span> ';

/** Error messages -> "<p>...</p>" fragments. @param string[] $messages */
function renderErrors(array $messages): string
{
    $html = '';
    foreach ($messages as $message) {
        $html .= '<p>' . htmlspecialchars($message) . '</p>';
    }
    return $html;
}

/** 4 -> 13 -> 4 style chain with the site's arrow between steps. @param int[] $steps */
function renderSteps(array $steps): string
{
    return implode(PROCESS_ARROW, array_map('strval', $steps));
}

/** "Label: raw -> step -> step" line (Birth Day, Birth Month, ...). */
function renderProcessLine(string $label, int $raw, array $steps, bool $final = false): string
{
    $class = 'process-line' . ($final ? ' process-final' : '');
    return '<p class="' . $class . '"><span class="process-label">' . htmlspecialchars($label) . ':</span> '
        . $raw . PROCESS_ARROW . renderSteps($steps) . '</p>';
}

/** "Label: value" line. $valueHtml must already be safe HTML. */
function renderValueLine(string $label, string $valueHtml): string
{
    return '<p class="process-line"><span class="process-label">' . htmlspecialchars($label) . ':</span> '
        . $valueHtml . '</p>';
}

/** Highlighted last line of the process card, e.g. "Life Path Number: 11/2". */
function renderFinalLine(string $text): string
{
    return '<p class="process-line process-final">' . htmlspecialchars($text) . '</p>';
}

/** "A + B = total -> steps" line. @param int[] $addends @param int[] $steps */
function renderSumLine(string $label, array $addends, int $total, array $steps): string
{
    return renderValueLine(
        $label,
        implode(' + ', $addends) . ' = ' . $total . PROCESS_ARROW . renderSteps($steps)
    );
}

/**
 * "Letter values: J=1, O=6, ..." line.
 * @param array<int,array{letter:string,value:int}> $breakdown
 */
function renderLetterValuesLine(array $breakdown, string $label = 'Letter values'): string
{
    $text = implode(', ', array_map(
        fn ($entry) => strtoupper($entry['letter']) . '=' . $entry['value'],
        $breakdown
    ));
    return renderValueLine($label, htmlspecialchars($text));
}

/**
 * "Reduction: 1+6+5 -> 12 -> 3" line for a name.
 * @param array<int,array{letter:string,value:int}> $breakdown
 * @param int[] $steps
 */
function renderNameReductionLine(array $breakdown, array $steps, string $label = 'Reduction'): string
{
    return renderValueLine(
        $label,
        implode('+', array_map(fn ($entry) => $entry['value'], $breakdown))
            . PROCESS_ARROW . renderSteps($steps)
    );
}

/**
 * The four Life Path working lines: Birth Day, Birth Month, Birth
 * Year and their Sum. $lifePath comes from computeLifePath().
 *
 * @return string[]
 */
function renderLifePathLines(array $lifePath, int $day, int $month, int $year): array
{
    return [
        renderProcessLine('Birth Day', $day, $lifePath['daySteps']),
        renderProcessLine('Birth Month', $month, $lifePath['monthSteps']),
        renderProcessLine('Birth Year', $year, $lifePath['yearSteps']),
        renderSumLine(
            'Sum',
            [$lifePath['dayFinal'], $lifePath['monthFinal'], $lifePath['yearFinal']],
            $lifePath['total'],
            $lifePath['totalSteps']
        ),
    ];
}

/**
 * One interpretation block. An entry is either
 *   ['title' => ..., 'paragraphs' => [...]]      (short readings), or
 *   ['title' => ..., 'sections' => [[label, text], ...]]   (full readings)
 * Returns the standard "being written" note when there is no entry.
 */
function renderReading(?array $entry): string
{
    if (!$entry) {
        return '<p>This reading is being written — check back soon.</p>';
    }

    $html = '<p><strong>' . htmlspecialchars($entry['title']) . '</strong></p>';

    foreach ($entry['paragraphs'] ?? [] as $paragraph) {
        $html .= '<p>' . htmlspecialchars($paragraph) . '</p>';
    }
    foreach ($entry['sections'] ?? [] as [$label, $text]) {
        $html .= '<p><strong>' . htmlspecialchars($label) . ':</strong> ' . htmlspecialchars($text) . '</p>';
    }
    return $html;
}

/** Several readings in a row, separated by the standard divider. @param array[] $entries */
function renderReadingList(array $entries): string
{
    return implode('<hr class="section-divider" />', array_map('renderReading', $entries));
}
