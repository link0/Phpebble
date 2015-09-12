<?php

namespace Link0\Phpebble\Api;

use PHPUnit_Framework_TestCase;
use Prophecy\Exception\InvalidArgumentException;

final class TimelineTokenTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid token length
     */
    public function test_that_token_must_not_be_less_then_32_characters()
    {
        TimelineToken::fromString(str_repeat('a', 31));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid token length
     */
    public function test_that_token_must_not_be_more_then_32_characters()
    {
        TimelineToken::fromString(str_repeat('a', 33));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid token, should contain hexadecimal value
     */
    public function test_that_token_only_accepts_hexadecimal_characters()
    {
        TimelineToken::fromString(str_repeat('z', 32));
    }

    public function test_that_token_string_representation_is_unaltered()
    {
        $tokenString = str_repeat('a', 32);
        $token = TimelineToken::fromString($tokenString);

        $this->assertEquals($tokenString, $token->toString());
        $this->assertEquals($tokenString, (string) $token);
    }
}