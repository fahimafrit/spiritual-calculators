<?php
declare(strict_types=1);

/* Sends the same inputs to the old Life Path endpoint and the new
   dispatcher route, and checks that the decoded JSON is identical.
   Usage (server running on the same address):
     php tests/numerology/compare-life-path.php http://localhost:8000 */

$base = rtrim($argv[1] ?? 'http://localhost:8000', '/');
$oldUrl = $base . '/numerology/api/life-path-calculate.php';
$newUrl = $base . '/calculate.php?slug=life-path-number';

function sendPost(string $url, string $date): ?array
{
    $ctx = stream_context_create(['http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/x-www-form-urlencoded',
        'content' => 'date=' . rawurlencode($date),
        'ignore_errors' => true,
        'timeout' => 10,
    ]]);
    $raw = @file_get_contents($url, false, $ctx);
    return $raw === false ? null : json_decode($raw, true);
}

$dates = [
    '01/01/2000', '29/02/2000', '29/02/1900', '31/04/2001', '32/01/2000',
    '00/01/2000', '15/13/2000', '01/01/2999', '', 'abc', '1/1/2000',
    '01-01-2000', '29/11/1992', '22/02/1988', '11/11/1911', '03/03/1933',
    '22/05/1950', '22/04/1951',
];

mt_srand(42);
for ($i = 0; $i < 400; $i++) {
    $y = mt_rand(1900, 2025);
    $m = mt_rand(1, 12);
    $d = mt_rand(1, (int) date('t', mktime(0, 0, 0, $m, 1, $y)));
    $dates[] = sprintf('%02d/%02d/%04d', $d, $m, $y);
}

$same = 0;
$bad = 0;
$numbers = [];

foreach ($dates as $date) {
    $old = sendPost($oldUrl, $date);
    $new = sendPost($newUrl, $date);

    if ($old !== null && $old === $new) {
        $same++;
        if (($old['valid'] ?? false) === true) {
            $numbers[$old['numValue']] = true;
        }
    } else {
        $bad++;
        echo "MISMATCH for date: '" . $date . "'\n";
    }
}

ksort($numbers);
echo "Compared: " . count($dates) . " | identical: $same | different: $bad\n";
echo "Result values seen: " . implode(', ', array_keys($numbers)) . "\n";
exit($bad === 0 ? 0 : 1);