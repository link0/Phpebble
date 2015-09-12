<?php

namespace Link0\Phpebble\Api;

use PHPUnit_Framework_TestCase;

final class InvalidTimelineTokenTest extends PHPUnit_Framework_TestCase
{
    public function test_that_exception_string_is_dependent_on_token()
    {
        $tokenString = str_repeat('0123456789abcdef', 2);
        $token = TimelineToken::fromString($tokenString);

        $invalidTimelineToken = new InvalidTimelineToken($token);

        $this->assertSame("Invalid Timeline token: {$tokenString}", $invalidTimelineToken->getMessage());
    }
}