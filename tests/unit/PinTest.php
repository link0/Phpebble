<?php

namespace Link0\Phpebble;

use PHPUnit_Framework_TestCase;

final class PinTest extends PHPUnit_Framework_TestCase
{
    public function test_json_structure()
    {
        $id = 'someidentifier-31337';
        $dateTime = new \DateTimeImmutable();
        $title = 'Some Title';

        $pin = Pin::create($id, $dateTime, $title);
        $json = $pin->json();
        $jsonObject = json_decode($json);
        $this->assertInstanceOf('stdClass', $jsonObject);

        $this->assertEquals($id, $jsonObject->id);
        $this->assertEquals($dateTime->format(DATE_ATOM), $jsonObject->time);
        $this->assertEquals($title, $jsonObject->layout->title);
    }
}