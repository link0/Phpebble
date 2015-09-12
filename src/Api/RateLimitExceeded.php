<?php

namespace Link0\Phpebble\Api;

use Link0\Phpebble\Exception;

final class RateLimitExceeded extends Exception
{
    /**
     * RateLimitExceeded constructor.
     */
    public function __construct()
    {
        parent::__construct("API RateLimit exceeded");
    }
}