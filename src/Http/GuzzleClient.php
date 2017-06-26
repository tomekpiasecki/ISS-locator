<?php

declare(strict_types = 1);

namespace Isslocator\Http;

use GuzzleHttp\Client as GuzzleHttpClient;
use Isslocator\Exception\RequestException;

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
     * Sends http request
     *
     * @param string $method Http method
     * @param string $uri JSON api endpoint
     * @param array $options
     * @return array Associative array containing decoded response body
     * @throws RequestException
     */
    public function request(string $method, string $uri = '', array $options = []):array
    {
        try {
            $this->response = $this->guzzleClient->request($method, $uri, $options);
            if (!$this->wasRequestSuccessful()) {
                throw new \RuntimeException("Request to $uri completed with status {$this->response->getStatusCode()}");
            }

            $this->decodeResponse();
        } catch (\Throwable $ex ) {
            throw new RequestException("Failed to process request to $uri", 0, $ex);
        }

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
     * @throws \InvalidArgumentException
     */
    protected function decodeResponse()
    {
        $this->response = json_decode((string)$this->response->getBody(), true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \InvalidArgumentException('json_decode error: ' . json_last_error_msg());
        }
    }
}
