<?php

declare(strict_types = 1);

namespace Isslocator\Http;

use GuzzleHttp\Client as GuzzleHttpClient;

class GuzzleClient implements Client
{
    /**
     * @var GuzzleHttpClient
     */
    private $guzzleClient;

    public function __construct(GuzzleHttpClient $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @inheritdoc
     */
    public function request(string $method, string $uri = '', array $options = [])
    {
        return $this->guzzleClient->request($method, $uri, $options);
    }
}
