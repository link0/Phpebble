<?php

namespace Link0\Phpebble\Api;

use Exception;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use Link0\Phpebble\Pin;

/**
 * Timeline implementation based upon the GuzzleHttp client
 *
 * @package Link0\Phpebble\Api
 */
final class GuzzleTimeline implements Timeline
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var TimelineToken
     */
    private $token;

    /**
     * @var string
     */
    private $baseUri;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client, TimelineToken $token)
    {
        $this->baseUri = $client->getConfig('base_uri');
        if ($this->baseUri === null) {
            $this->baseUri = 'https://timeline-api.getpebble.com';
        }

        $this->token = $token;
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function push(Pin $pin)
    {
        $this->pinRequest($pin, 'PUT');
    }

    public function remove(Pin $pin)
    {
        $this->pinRequest($pin, 'DELETE');
    }

    /**
     * @param Pin $pin
     * @param string $method
     *
     * @throws Exception
     * @throws InvalidTimelineToken
     */
    private function pinRequest(Pin $pin, $method)
    {
        $body = null;
        if ($method === 'PUT') {
            $body = $pin->json();
        }

        $uri = trim($this->baseUri, '/') . '/v1/user/pins/' . $pin->id();
        $request = new Request($method, $uri, $this->getHeaders(), $body);

        try {
            $this->client->send($request);
        } catch (ClientException $exception) {
            $this->handleException($exception, $pin);
        } catch (ServerException $exception) {
            $this->handleException($exception, $pin);
        }
    }

    /**
     * @param array $customHeaders
     *
     * @return array
     */
    private function getHeaders($customHeaders = [])
    {
        return array_merge([
            'Content-Type' => 'application/json',
            'X-User-Token' => $this->token->toString(),
        ], $customHeaders);
    }

    /**
     * @param BadResponseException $exception
     * @param Pin $pin
     *
     * @throws InvalidTimelineToken
     * @throws Exception
     */
    private function handleException(BadResponseException $exception, Pin $pin)
    {
        switch($exception->getCode()) {
            case 400: // Invalid pin object
                throw new InvalidPinObject($pin);
            case 403: // Invalid API key
                throw new InvalidTimelineToken($this->token);
            case 410: // Invalid user token
                throw new InvalidTimelineToken($this->token);
            case 429: // Rate-limit exceeded
                throw new RateLimitExceeded();
            case 503: // Service unavailable
                throw new ServiceUnavailable();
        }
        throw new Exception("Invalid API call, reason unknown");
    }
}