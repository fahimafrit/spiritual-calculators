<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   LOVE CALCULATOR — HANDLER
   Input:  { name1, name2 }
   Output: { valid: true, percent (1-99), band (0-5), title, readingHtml,
             name1, name2 } or { valid: false, errorsHtml }

   The percentage comes from the letters L, O, V, E and S in the two
   names. It does not depend on capitals, spaces, accents or on which
   name is entered first.
   Called through the dispatcher: POST /calculate.php?slug=love-calculator
   ════════════════════════════════════════════════════════════════════ */

$loveReadings = require __DIR__ . '/readings.php';

function love_errors(array $messages): array
{
    $html = '';
    foreach ($messages as $message) {
        $html .= '<p>' . htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</p>';
    }
    return ['valid' => false, 'errorsHtml' => $html];
}

/** Capital A-Z letters only: accents are dropped, other scripts are ignored. */
function love_latin_letters(string $name): string
{
    if (class_exists('Normalizer')) {
        $name = (string) Normalizer::normalize($name, Normalizer::FORM_D);
    }
    return strtoupper((string) preg_replace('/[^A-Za-z]/', '', $name));
}

/** Percentage 1-99 from the combined letters of both names. */
function love_percent(string $letters): int
{
    $digits = [];
    foreach (['L', 'O', 'V', 'E', 'S'] as $letter) {
        foreach (str_split((string) substr_count($letters, $letter)) as $d) {
            $digits[] = (int) $d;
        }
    }
    while (count($digits) > 2) {
        $next = [];
        for ($i = 0; $i < count($digits) - 1; $i++) {
            foreach (str_split((string) ($digits[$i] + $digits[$i + 1])) as $d) {
                $next[] = (int) $d;
            }
        }
        $digits = $next;
    }
    return max(1, (int) implode('', $digits));
}

function love_band(int $percent): int
{
    if ($percent < 20) { return 0; }
    if ($percent < 40) { return 1; }
    if ($percent < 60) { return 2; }
    if ($percent < 75) { return 3; }
    if ($percent < 90) { return 4; }
    return 5;
}

return function (array $input) use ($loveReadings): array {
    $name1 = trim((string) preg_replace('/\s+/u', ' ', (string) ($input['name1'] ?? '')));
    $name2 = trim((string) preg_replace('/\s+/u', ' ', (string) ($input['name2'] ?? '')));

    $errors = [];
    if ($name1 === '' || !preg_match('/\p{L}/u', $name1)) {
        $errors[] = 'Enter your name.';
    }
    if ($name2 === '' || !preg_match('/\p{L}/u', $name2)) {
        $errors[] = 'Enter their name.';
    }
    if ($errors) {
        return love_errors($errors);
    }
    if (mb_strlen($name1) > 60 || mb_strlen($name2) > 60) {
        return love_errors(['Each name can be up to 60 characters.']);
    }

    $letters = love_latin_letters($name1) . love_latin_letters($name2);
    if ($letters === '') {
        return love_errors(['Please enter the names using English letters.']);
    }

    $percent = love_percent($letters);
    $band = love_band($percent);
    $reading = $loveReadings[$band];

    $html = '';
    foreach ($reading['sections'] as [$label, $text]) {
        $html .= '<div class="reading-block"><h3>' . htmlspecialchars($label, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
            . '</h3><p>' . htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</p></div>';
    }

    return [
        'valid' => true,
        'name1' => $name1,
        'name2' => $name2,
        'percent' => $percent,
        'band' => $band,
        'title' => $reading['title'],
        'readingHtml' => $html,
    ];
};
