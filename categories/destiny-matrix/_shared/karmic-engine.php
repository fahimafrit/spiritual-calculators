<?php
declare(strict_types=1);

/* ════════════════════════════════════════════════════════════════════
   KARMIC TAIL — CALCULATION + READING ENGINE (PHP)
   Server-side port of everything that used to live inside
   karmic-tail-calculator.html: the name formatting, the cluster
   lookup (jpoint-rpoint-dpoint) and the HTML for the karmic tail
   reading.

   Belongs to the Destiny Matrix category. It builds on the shared
   Destiny Matrix engine (php/engine.php) for point reduction, the
   chart calculation, date handling and input validation. Every
   function here is prefixed kt_ so it can never clash with another
   engine. Reads the guarded reading file in
   destiny-matrix/php/karmic-readings/ (generated from the source
   JSON by tools/wrap-json.php).
   Never included directly from a browser request — the endpoint
   defines SPIRITUAL_APP before requiring it.
   ════════════════════════════════════════════════════════════════════ */

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

require_once __DIR__ . '/engine.php';

const KT_READINGS_DIR = __DIR__ . '/karmic-readings/';

/* ── File access ──────────────────────────────────────────────────── */

/**
 * Loads the karmic tail manifest (one entry per cluster). Empty array
 * if the guarded file is missing or unreadable.
 *
 * @return array<int, array<string,mixed>>
 */
function kt_loadEntries(): array
{
    static $entries = null;
    if ($entries !== null) {
        return $entries;
    }

    $path = KT_READINGS_DIR . 'karmic-manifest.php';
    $loaded = is_file($path) ? include $path : null;
    $entries = is_array($loaded) ? $loaded : [];
    return $entries;
}

/** The manifest entry whose cluster matches, or null. */
function kt_findEntry(string $cluster): ?array
{
    foreach (kt_loadEntries() as $entry) {
        if (($entry['cluster'] ?? null) === $cluster) {
            return $entry;
        }
    }
    return null;
}

/* ── HTML helpers ─────────────────────────────────────────────────── */

/** Escapes & < > only, exactly like the browser-side helper did. */
function kt_escape($value): string
{
    return htmlspecialchars((string) $value, ENT_NOQUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Capitalizes the first letter of every space-separated word and
 * lowercases the rest (the Karmic Tail page's own name formatting).
 */
function kt_titleCase(string $str): string
{
    return (string) preg_replace_callback(
        '/\S+/u',
        static function (array $m): string {
            $word = $m[0];
            if (function_exists('mb_strtoupper')) {
                return mb_strtoupper(mb_substr($word, 0, 1, 'UTF-8'), 'UTF-8')
                    . mb_strtolower(mb_substr($word, 1, null, 'UTF-8'), 'UTF-8');
            }
            return strtoupper(substr($word, 0, 1)) . strtolower(substr($word, 1));
        },
        $str
    );
}

function kt_renderPosition(array $position): string
{
    return '
    <div class="karmic-position">
      <p class="karmic-position-heading">' . kt_escape($position['roman']) . ' &middot; <span class="arcana-name">' . kt_escape($position['arcana']) . '</span> — ' . kt_escape($position['role']) . '</p>
      <p>' . kt_escape($position['text']) . '</p>
    </div>';
}

function kt_renderEntry(array $entry): string
{
    $positionsHtml = '';
    foreach ($entry['positions'] as $position) {
        $positionsHtml .= kt_renderPosition($position);
    }

    return '
    <div class="karmic-triplet-badge"><span>' . kt_escape($entry['name']) . '</span></div>
    ' . $positionsHtml . '
    <div class="karmic-summary-grid">
      <div class="karmic-summary-block shadow">
        <h3>Shadow</h3>
        <p>' . kt_escape($entry['shadow']) . '</p>
      </div>
      <div class="karmic-summary-block integrated">
        <h3>Integrated</h3>
        <p>' . kt_escape($entry['integrated']) . '</p>
      </div>
      <div class="karmic-summary-block practical">
        <h3>Where It Shows Up</h3>
        <p>' . kt_escape($entry['practical']) . '</p>
      </div>
    </div>
    <div class="karmic-cta">
      <p>This is one thread. Your full Destiny Matrix reading maps how it connects to everything else in your chart.</p>
      <a href="../destiny-matrix/destiny-matrix.html" target="_blank">Get your full Destiny Matrix reading</a>
    </div>';
}

/* ── Result ───────────────────────────────────────────────────────── */

/**
 * Builds everything the page needs for a validated submission.
 *
 * readingHtml is '' when no reading exists yet for this chart's
 * cluster; the page then shows its "being written" message.
 *
 * @param array{day:int, month:int, year:int} $parsed
 * @return array{headerHtml:string, values:array<string,int>, readingHtml:string}
 */
function kt_buildResult(array $parsed, string $name): array
{
    $person = dm_calculateFromDate($parsed);
    $points = $person['points'];

    $fullDate = dm_formatLongDate($parsed['day'], $parsed['month'], $parsed['year']);
    $headerHtml = htmlspecialchars(kt_titleCase($name), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
        . "'s <span class=\"gray\">Karmic Tail — Date of Birth: " . $fullDate . '</span>';

    $cluster = $points['jpoint'] . '-' . $points['rpoint'] . '-' . $points['dpoint'];
    $entry = kt_findEntry($cluster);

    return [
        'headerHtml' => $headerHtml,
        'values' => $points,
        'readingHtml' => $entry === null ? '' : kt_renderEntry($entry),
    ];
}