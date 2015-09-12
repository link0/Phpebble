<?php

namespace Link0\Phpebble\Api;

use Link0\Phpebble\Exception;

final class InvalidTimelineToken extends Exception
{
    /**
     * @var TimelineToken
     */
    private $timelineToken;

    /**
     * InvalidTimelineToken constructor.
     *
     * @param TimelineToken $token
     */
    public function __construct(TimelineToken $token)
    {
        $this->timelineToken = $token;

        parent::__construct("Invalid Timeline token: " . $token->toString());
    }

    /**
     * @return TimelineToken
     */
    public function timelineToken()
    {
        return $this->timelineToken;
    }
}