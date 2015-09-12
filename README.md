Phpebble
========

This package encapsulates external services provided by Pebble to interact with the Pebble Smartwatch

License: [MIT](LICENSE)

Usage
=====

You can install using composer

`composer require link0/phpebble`

Quickstart
==========
```php
<?php

use GuzzleHttp\Client;
use Link0\Phpebble\Api\GuzzleTimeline;
use Link0\Phpebble\Api\InvalidPinObject;
use Link0\Phpebble\Api\InvalidTimelineToken;
use Link0\Phpebble\Api\RateLimitExceeded;
use Link0\Phpebble\Api\ServiceUnavailable;
use Link0\Phpebble\Api\TimelineToken;
use Link0\Phpebble\Pin;

require_once('vendor/autoload.php');

$token = TimelineToken::fromString('0123456789abcdef0123456789abcdef');
$pin = Pin::create('foo-31337', new \DateTimeImmutable(), 'Some title');

$api = new GuzzleTimeline(new Client(), $token);

try {
    $api->push($pin);
    printf("%s\n", "Succesfully processed Pin " . $pin->id());
}
catch(InvalidPinObject $ipo) {
    printf("%s\n", $ipo->getMessage());
    print_r($ipo->pin());
}
catch(InvalidTimelineToken $itt) {
    printf("%s\n", $itt->getMessage());
    print_r($itt->timelineToken());
}
catch(RateLimitExceeded $rle) {
    printf("%s\n", $rle->getMessage());
}
catch(ServiceUnavailable $su) {
    printf("%s\n", $su->getMessage());
}

```