<?php

namespace Link0\Phpebble\Api;

use Link0\Phpebble\Pin;

/**
 * Timeline API interface
 * @see http://developer.getpebble.com/guides/timeline/timeline-public/
 *
 * @package Link0\Phpebble\Api
 */
interface Timeline
{
    /**
     * Pushes a Pin to the Timeline
     *
     * @param Pin $pin
     *
     * @return void
     */
    public function push(Pin $pin);

    /**
     * Removes a Pin from the Timelin
     *
     * @param Pin $pin
     *
     * @return void
     */
    public function remove(Pin $pin);
}