<?php
declare(strict_types=1);

/* Data for the Wedding Date Numerology calculator.
   Server-side only: never included from a browser request. */

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* fit: how well a date number suits a person's Life Path Number, 0-100.
   Keyed by the two single-digit root numbers, lowest first ("3-5").
   Master numbers (11, 22, 33) use their root digit (2, 4, 6).

   readings:  date number (1-9, 11, 22, 33) => headline, story, strengths, watch, guidance
   fits:      pair key ("3-5") => ['text' => ...]       (one note per partner)
   marriage:  Marriage Number (1-9, 11, 22, 33) => same shape as readings
   The interpretations are filled in separately from the calculator. */

return [
    'fit' => [
        '1-1' => 65, '1-2' => 60, '1-3' => 85, '1-4' => 60, '1-5' => 90, '1-6' => 60, '1-7' => 80, '1-8' => 65, '1-9' => 70,
        '2-2' => 70, '2-3' => 65, '2-4' => 80, '2-5' => 55, '2-6' => 90, '2-7' => 55, '2-8' => 85, '2-9' => 80,
        '3-3' => 70, '3-4' => 50, '3-5' => 90, '3-6' => 80, '3-7' => 65, '3-8' => 50, '3-9' => 90,
        '4-4' => 70, '4-5' => 55, '4-6' => 85, '4-7' => 60, '4-8' => 90, '4-9' => 65,
        '5-5' => 70, '5-6' => 55, '5-7' => 85, '5-8' => 55, '5-9' => 75,
        '6-6' => 75, '6-7' => 60, '6-8' => 75, '6-9' => 90,
        '7-7' => 65, '7-8' => 60, '7-9' => 80,
        '8-8' => 70, '8-9' => 60,
        '9-9' => 70,
    ],
    'readings' => [],
    'fits' => [],
    'marriage' => [],
];