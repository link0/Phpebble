<?php

namespace Link0\Phpebble\Api;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Link0\Phpebble\Pin;
use Mockery;
use Mockery\Expectation;
use Mockery\MockInterface;
use PHPUnit_Framework_TestCase;

final class GuzzleTimelineTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ClientInterface|MockInterface
     */
    private $client;

    /**
     * @var Expectation
     */
    private $getConfigMethod;

    /**
     * @var Expectation
     */
    private $sendMethod;

    public function setUp()
    {
        $this->client = Mockery::mock(ClientInterface::class);

        $this->getConfigMethod = $this->client
            ->shouldReceive('getConfig')
            ->withArgs(['base_uri'])
            ->once()
            ->andReturnNull()
            ->byDefault()
        ;

        $this->sendMethod = $this->client
            ->shouldReceive('send')
            ->with(\Mockery::type(Request::class))
            ->byDefault()
        ;

    }

    public function test_successful_push_pin()
    {
        $this->performPush();
    }

    public function test_push_with_custom_base_uri()
    {
        $this->getConfigMethod
            ->andReturn('http://example.com');

        $this->performPush();
    }

    /**
     * @expectedException \Link0\Phpebble\Api\InvalidTimelineToken
     * @expectedExceptionMessage Invalid Timeline token: aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
     */
    public function test_invalid_api_key_call()
    {
        $this->sendMethod->andReturnUsing($this->createClientException(403));
        $this->performPush();
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Invalid API call, reason unknown
     */
    public function test_invalid_pin_object()
    {
        $this->sendMethod->andReturnUsing($this->createClientException(400));
        $this->performPush();
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Invalid API call, reason unknown
     */
    public function test_invalid_user_token()
    {
        $this->sendMethod->andReturnUsing($this->createClientException(410));
        $this->performPush();
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Invalid API call, reason unknown
     */
    public function test_rate_limit_exceeded()
    {
        $this->sendMethod->andReturnUsing($this->createClientException(429));
        $this->performPush();
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Invalid API call, reason unknown
     */
    public function test_service_unavailable()
    {
        $this->sendMethod->andReturnUsing($this->createClientException(503));
        $this->performPush();
    }

    public function test_successful_remove_pin()
    {
        $this->performRemove();
    }

    private function performPush()
    {
        $testData = $this->getTestData();
        $pin = $testData['pin'];

        $timeline = new GuzzleTimeline($this->client, $testData['token']);
        $timeline->push($pin);
    }

    private function performRemove()
    {
        $testData = $this->getTestData();
        $pin = $testData['pin'];

        $timeline = new GuzzleTimeline($this->client, $testData['token']);
        $timeline->remove($pin);
    }

    private function createClientException($httpCode)
    {
        return function(Request $request) use ($httpCode) {
            // Capture Request object so we can throw an ClientException
            $response = new Response($httpCode);
            throw ClientException::create($request, $response);
        };
    }

    private function getTestData()
    {
        $id = 'foobar-1234';
        $dateTime = new \DateTimeImmutable();
        $title = 'SomeTitle';
        $pin = Pin::create($id, $dateTime, $title);
        $token = TimelineToken::fromString(str_repeat('a', 32));

        return [
            'id' => $id,
            'dateTime' => $dateTime,
            'title' => $title,
            'pin' => $pin,
            'token' => $token,
            'timeline' => new GuzzleTimeline($this->client, $token)
        ];
    }
}