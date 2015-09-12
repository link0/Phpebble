<?php

namespace Link0\Phpebble\Api;

use InvalidArgumentException;

/**
 * This value-object encapsulates a timeline token required to talk to
 * the Pebble Timeline API
 *
 * @package Link0\Phpebble\Api
 */
final class TimelineToken
{
    /**
     * @var string
     */
    private $token;

    /**
     * @param string $token
     */
    private function __construct($token)
    {
        if (strlen($token) !== 32) {
            throw new InvalidArgumentException("Invalid token length");
        }

        if (ctype_xdigit($token) !== true) {
            throw new InvalidArgumentException("Invalid token, should contain hexadecimal value");
        }

        $this->token = $token;
    }

    /**
     * @param $token
     *
     * @return TimelineToken
     */
    public static function fromString($token)
    {
        return new self($token);
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}