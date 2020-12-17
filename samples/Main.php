<?php

/**
 * Sample usage of \KEINOS\MSTDN_TOOLS\Listener class to receive server-sent
 * messages from Mastodon API as JSON objects.
 */

declare(strict_types=1);

namespace KEINOS\MSTDN_TOOLS;

require_once __DIR__ . '/../vendor/autoload.php';

use KEINOS\MSTDN_TOOLS\Listener\Listener;

$conf = [
    'url_host' => 'https://qiitadon.com/',
    'flag_mode_debug' => false, // false is the default
    'type_stream' => 'local',   // 'public' is the default
];

$hello = new Listener($conf);

$option_json_encode = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
foreach ($hello as $key => $value) {
    echo "${key}\t" . json_encode(json_decode($value), $option_json_encode) . PHP_EOL;
    if ($key === "delete") {
        exit();
    }
}
