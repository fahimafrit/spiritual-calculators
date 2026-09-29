<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   REGISTRY
   Reads core/registry.json and turns a slug into a handler file path.
   Only slugs listed in the registry can ever run. Every value used to
   build a path is checked against a strict pattern first.

   Registry entry:
     "life-path-number": { "category": "numerology" }
   Optional keys, for the rare calculator that needs them:
     "folder": folder name when it differs from the slug
     "file":   handler file name when it is not handler.php
   ════════════════════════════════════════════════════════════════════ */

function sc_registry(): array
{
    static $registry = null;

    if ($registry === null) {
        $raw = @file_get_contents(SPIRITUAL_ROOT . '/core/registry.json');
        $data = $raw === false ? null : json_decode($raw, true);
        $registry = is_array($data['calculators'] ?? null) ? $data['calculators'] : [];
    }

    return $registry;
}

function sc_find_calculator(string $slug): ?array
{
    $namePattern = '/^_?[a-z0-9]+(?:-[a-z0-9]+)*$/';

    if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $slug)) {
        return null;
    }

    $entry = sc_registry()[$slug] ?? null;
    if (!is_array($entry)) {
        return null;
    }

    $category = $entry['category'] ?? '';
    $folder = $entry['folder'] ?? $slug;
    $file = $entry['file'] ?? 'handler.php';

    if (
        !is_string($category) || !preg_match($namePattern, $category)
        || !is_string($folder) || !preg_match($namePattern, $folder)
        || !is_string($file) || !preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*\.php$/', $file)
    ) {
        return null;
    }

    $path = SPIRITUAL_ROOT . '/categories/' . $category . '/' . $folder . '/' . $file;
    if (!is_file($path)) {
        return null;
    }

    return ['slug' => $slug, 'category' => $category, 'handler' => $path];
}