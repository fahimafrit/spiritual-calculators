<?php
declare(strict_types=1);

/* ════════════════════════════════════════════════════════════════════
   DESTINY MATRIX — READING BUILDER (PHP)
   Server-side port of the interpretation code that used to live in
   destiny-matrix-calculator.html: the section manifest, the lookup
   rules (arcana / cluster / chakra), and the HTML for each section.

   Reads the guarded reading files in destiny-matrix/php/readings/
   (generated from the source JSON by tools/wrap-json.php).
   Never included directly from a browser request.
   ════════════════════════════════════════════════════════════════════ */

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

const DM_READINGS_DIR = __DIR__ . '/readings/';

const DM_CHAKRAS = [
    'sah' => ['name' => 'Sahasrara', 'color' => 'var(--chakra-sahasrara)'],
    'aj' => ['name' => 'Ajna', 'color' => 'var(--chakra-ajna)'],
    'vish' => ['name' => 'Vishuddha', 'color' => 'var(--chakra-vishuddha)'],
    'anah' => ['name' => 'Anahata', 'color' => 'var(--chakra-anahata)'],
    'man' => ['name' => 'Manipura', 'color' => 'var(--chakra-manipura)'],
    'svad' => ['name' => 'Svadhisthana', 'color' => 'var(--chakra-svadhisthana)'],
    'mul' => ['name' => 'Muladhara', 'color' => 'var(--chakra-muladhara)'],
];

const DM_CHAKRA_FULL_NAME = [
    'sah' => 'sahasrara', 'aj' => 'ajna', 'vish' => 'vishuddha', 'anah' => 'anahata',
    'man' => 'manipura', 'svad' => 'svadhisthana', 'mul' => 'muladhara',
];

/* ── File access ──────────────────────────────────────────────────── */

/** Loads one guarded reading file by name (no extension). Null if missing/unreadable. */
function dm_loadReadingFile(string $name): ?array
{
    static $cache = [];
    if (array_key_exists($name, $cache)) {
        return $cache[$name];
    }

    $path = DM_READINGS_DIR . basename($name) . '.php';
    $data = null;
    if (is_file($path)) {
        $loaded = include $path;
        $data = is_array($loaded) ? $loaded : null;
    }

    $cache[$name] = $data;
    return $data;
}

/* ── HTML helpers ─────────────────────────────────────────────────── */

/** Escapes & < > only, exactly like the browser-side helper did. */
function dm_escape($value): string
{
    return htmlspecialchars((string) $value, ENT_NOQUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** @param array<int, array{label:string, contentHtml:string}> $items */
function dm_renderTabsAndPanels(array $items): string
{
    $tabs = '';
    $panels = '';
    foreach ($items as $i => $item) {
        $active = $i === 0 ? ' active' : '';
        $tabs .= "\n    <button type=\"button\" class=\"reading-tab{$active}\" data-tab-index=\"{$i}\">{$item['label']}</button>\n  ";
        $panels .= "\n    <div class=\"reading-tab-panel{$active}\" data-tab-index=\"{$i}\">{$item['contentHtml']}</div>\n  ";
    }

    return "\n    <div class=\"reading-tabs\" role=\"tablist\">{$tabs}</div>\n"
        . "    <div class=\"reading-tab-panels\">{$panels}</div>\n  ";
}

function dm_buildSectionDropdownHtml(array $section, array $items): ?string
{
    if (count($items) === 0) {
        return null;
    }

    return "\n    <details class=\"reading-section\" id=\"reading-{$section['id']}\">\n"
        . '      <summary class="reading-section-title"><span class="reading-chevron">&#8250;</span>'
        . dm_escape($section['title']) . "</summary>\n"
        . "      <div class=\"reading-section-body\">\n        "
        . dm_renderTabsAndPanels($items)
        . "\n      </div>\n    </details>\n  ";
}

/* ── Lookups ──────────────────────────────────────────────────────── */

/** Standard "arcana" lookup: entries keyed by an integer 1-22. */
function dm_findArcanaEntry(?array $fileData, $value): ?array
{
    if ($fileData === null) {
        return null;
    }
    foreach ($fileData as $entry) {
        if (is_array($entry) && array_key_exists('arcana', $entry) && $entry['arcana'] === $value) {
            return $entry;
        }
    }
    return null;
}

/** Cluster lookup (Soul's Journey): entries keyed by a "j-k-l" string. */
function dm_findClusterEntry(?array $fileData, string $clusterKey): ?array
{
    if ($fileData === null) {
        return null;
    }
    foreach ($fileData as $entry) {
        if (is_array($entry) && array_key_exists('cluster', $entry) && $entry['cluster'] === $clusterKey) {
            return $entry;
        }
    }
    return null;
}

/** Resolves the lookup key for a manifest section from the computed points. */
function dm_resolveSectionKey(array $section, array $person, int $currentYearArcana)
{
    $lookup = $section['lookup'] ?? '';

    if ($lookup === 'cluster') {
        $values = [];
        foreach ($section['sourcePoints'] as $p) {
            if (!isset($person['points'][$p])) {
                return null;
            }
            $values[] = $person['points'][$p];
        }
        return implode('-', $values);
    }

    if ($lookup === 'arcana') {
        if (($section['derived'] ?? null) === 'personalYear') {
            return $currentYearArcana;
        }
        $key = $section['sourcePoints'][0];
        if (array_key_exists($key, $person['points'])) {
            return $person['points'][$key];
        }
        if (array_key_exists($key, $person['purposes'])) {
            return $person['purposes'][$key];
        }
        return null;
    }

    return null;
}

/* ── Section builders ─────────────────────────────────────────────── */

/** Each subsection (heading + text) becomes one tab in the dropdown. */
function dm_buildStandardSectionHtml(array $section, ?array $entry): ?string
{
    if ($entry === null || !isset($entry['subsections']) || !is_array($entry['subsections'])
        || count($entry['subsections']) === 0) {
        return null;
    }

    $items = [];
    foreach ($entry['subsections'] as $sub) {
        $items[] = [
            'label' => dm_escape($sub['heading'] ?? ''),
            'contentHtml' => '<p class="reading-subsection-text">' . dm_escape($sub['text'] ?? '') . '</p>',
        ];
    }
    return dm_buildSectionDropdownHtml($section, $items);
}

/** Picks one text (physics / energy / emotions) from a chakra entry. */
function dm_chakraText(array $entry, string $facet, $value): ?string
{
    $textKey = $facet . '_text';
    if (isset($entry[$textKey]) && $entry[$textKey] !== '') {
        return (string) $entry[$textKey];
    }
    if (isset($entry[$facet]) && is_array($entry[$facet])
        && isset($entry[$facet][(string) $value]) && $entry[$facet][(string) $value] !== '') {
        return (string) $entry[$facet][(string) $value];
    }
    return null;
}

/** Body & Energy Map: one dropdown, one tab per chakra. */
function dm_buildChakraSectionHtml(array $section, ?array $chakraFileData, array $chartHeart): ?string
{
    if ($chakraFileData === null || count($chakraFileData) === 0) {
        return null;
    }

    $items = [];
    foreach (DM_CHAKRA_FULL_NAME as $abbrev => $fullName) {
        $entry = null;
        foreach ($chakraFileData as $candidate) {
            if (is_array($candidate) && ($candidate['chakra'] ?? null) === $fullName) {
                $entry = $candidate;
                break;
            }
        }
        if ($entry === null) {
            continue;
        }

        $paragraphs = [];
        foreach (['physics', 'energy', 'emotions'] as $facet) {
            $text = dm_chakraText($entry, $facet, $chartHeart[$abbrev . $facet] ?? null);
            if ($text !== null) {
                $paragraphs[] = $text;
            }
        }
        if (count($paragraphs) === 0) {
            continue;
        }

        $meta = DM_CHAKRAS[$abbrev];
        $contentHtml = '';
        foreach ($paragraphs as $p) {
            $contentHtml .= '<p class="reading-subsection-text">' . dm_escape($p) . '</p>';
        }

        $items[] = [
            'label' => '<span class="reading-chakra-dot" style="background:' . $meta['color'] . ';"></span>'
                . dm_escape($meta['name']),
            'contentHtml' => $contentHtml,
        ];
    }

    return dm_buildSectionDropdownHtml($section, $items);
}

/** Builds one manifest section. Null when there is nothing to show. */
function dm_renderSection(array $section, array $person, int $currentYearArcana): ?string
{
    try {
        $fileData = dm_loadReadingFile((string) preg_replace('/\.json$/', '', $section['file']));

        if (($section['lookup'] ?? '') === 'chakra') {
            return dm_buildChakraSectionHtml($section, $fileData, $person['chartHeart']);
        }

        $key = dm_resolveSectionKey($section, $person, $currentYearArcana);
        if ($key === null) {
            return null;
        }

        $entry = ($section['lookup'] ?? '') === 'cluster'
            ? dm_findClusterEntry($fileData, (string) $key)
            : dm_findArcanaEntry($fileData, $key);

        return dm_buildStandardSectionHtml($section, $entry);
    } catch (Throwable $e) {
        return null;
    }
}

/**
 * The full reading for one person, as a single HTML string.
 * Empty string when no section has content yet.
 */
function dm_buildReadingHtml(array $person, int $currentYearArcana): string
{
    $manifest = dm_loadReadingFile('destiny-manifest');
    if ($manifest === null || !isset($manifest['sections']) || !is_array($manifest['sections'])) {
        return '';
    }

    $sections = $manifest['sections'];
    usort($sections, static fn (array $a, array $b): int => $a['order'] <=> $b['order']);

    $html = '';
    foreach ($sections as $section) {
        $chunk = dm_renderSection($section, $person, $currentYearArcana);
        if ($chunk !== null && $chunk !== '') {
            $html .= $chunk;
        }
    }
    return $html;
}