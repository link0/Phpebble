Phpebble
========
[![Latest Stable Version](https://poser.pugx.org/link0/phpebble/v/stable.svg)](https://packagist.org/packages/link0/phpebble)
[![Total Downloads](https://poser.pugx.org/link0/phpebble/downloads.svg)](https://packagist.org/packages/link0/phpebble)
[![License](https://poser.pugx.org/link0/phpebble/license.svg)](https://packagist.org/packages/link0/phpebble)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/link0/phpebble/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/link0/phpebble/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/link0/phpebble/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/link0/phpebble/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/link0/phpebble/badges/build.png?b=master)](https://scrutinizer-ci.com/g/link0/phpebble/build-status/master)

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