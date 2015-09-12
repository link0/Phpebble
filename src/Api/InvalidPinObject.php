<?php

namespace Link0\Phpebble\Api;

use Link0\Phpebble\Exception;
use Link0\Phpebble\Pin;

final class InvalidPinObject extends Exception
{
    /**
     * @var Pin
     */
    private $pin;

    /**
     * Invalid Pin object
     *
     * @param Pin $pin
     */
    public function __construct(Pin $pin)
    {
        $this->pin = $pin;

        parent::__construct("Invalid Pin object: " . $pin->id());
    }

    /**
     * @return Pin
     */
    public function pin()
    {
        return $this->pin;
    }
}