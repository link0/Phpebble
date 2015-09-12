<?php

namespace Link0\Phpebble\Api;

use Link0\Phpebble\Exception;

final class ServiceUnavailable extends Exception
{
    /**
     * ServiceUnavailable constructor.
     */
    public function __construct()
    {
        parent::__construct("Service unavailable");
    }
}