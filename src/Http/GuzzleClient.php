<?php

declare(strict_types = 1);

namespace Isslocator\Http;

use GuzzleHttp\Client as GuzzleHttpClient;

class GuzzleClient implements Client
{
    /**
     * @var GuzzleHttpClient
     */
    protected $guzzleClient;

    protected $response;

    public function __construct(GuzzleHttpClient $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @inheritdoc
     */
    public function request(string $method, string $uri = '', array $options = []):array
    {
        $this->response = $this->guzzleClient->request($method, $uri, $options);
        if (!$this->wasRequestSuccessful()) {
            throw new \Exception ('request failed');
        }

        $this->decodeResponse();

        return $this->response;
    }

    /**
     * Validates the response status code
     *
     * @return bool
     */
    protected function wasRequestSuccessful():bool
    {
        return $this->response->getStatusCode() === Client::RESPONSE_CODE_SUCCESS;
    }

    /**
     * Decodes JSON response to array
     *
     * @throws \Exception
     */
    protected function decodeResponse()
    {
        $this->response = json_decode((string)$this->response->getBody(), true);
        if (json_last_error()) {
            throw new \Exception ('request failed');
        }
    }
}
