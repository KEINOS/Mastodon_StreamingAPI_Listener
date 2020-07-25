[![](https://travis-ci.org/KEINOS/Mastodon_StreamingAPI_Listener.svg?branch=master)](https://travis-ci.org/KEINOS/Mastodon_StreamingAPI_Listener "View Build Status on Travis")
[![](https://img.shields.io/coveralls/github/KEINOS/Mastodon_StreamingAPI_Listener)](https://coveralls.io/github/KEINOS/Mastodon_StreamingAPI_Listener?branch=master "Code Coverage on COVERALLS")
[![](https://img.shields.io/scrutinizer/quality/g/KEINOS/Mastodon_StreamingAPI_Listener/master)](https://scrutinizer-ci.com/g/KEINOS/Mastodon_StreamingAPI_Listener/?branch=master "Code quality in Scrutinizer")
[![](https://img.shields.io/packagist/php-v/keinos/mastodon-streaming-api-parser)](https://github.com/KEINOS/Mastodon_StreamingAPI_Listener/blob/master/.travis.yml "Version Support")

# Simple Mastodon Streaming API Listener

This is a PHP class that listens to the Mastodon Streaming API's server-sent messages.

## Install

```bash
composer require keinos/mastodon-streaming-api-listener
```

## Usage

```php
<?php

namespace KEINOS\Sample;

require_once __DIR__ . '/../vendor/autoload.php';

use KEINOS\MSTDN_TOOLS\Listener\Listener;

$conf = [
    'url_host' => 'https://qiitadon.com/',
    // If the server is in "whitelist-mode" then you'll need an access token.
    //'access_token' => 'YOUR_ACCESS_TOKEN',
];

$listener = new Listener($conf);

/**
 * $listener ............ Iterator.
 *   $event_name ........ Event name. ("update" or "delete")
 *   $data_payload ...... Data of the event in JSON string.
 * @throws \Exception ... On any error occurred while listening.
 */
foreach($listener as $event_name => $data_payload) {
    echo 'Event name: ' . $event_name . PHP_EOL;
    echo 'Data: '. PHP_EOL;
    print_r(json_decode($data_payload));
}

```

## Package Information

- Packagist: https://packagist.org/packages/keinos/mastodon-streaming-api-listener
- Source: https://github.com/KEINOS/Mastodon_StreamingAPI_Listener
- Issues: https://github.com/KEINOS/Mastodon_StreamingAPI_Listener/issues
- License: [MIT](https://github.com/KEINOS/Mastodon_StreamingAPI_Listener/blob/master/LICENSE)
- Authors: [KEINOS and the contributors](https://github.com/KEINOS/Mastodon_StreamingAPI_Listener/graphs/contributors)