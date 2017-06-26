<?php

declare(strict_types = 1);

namespace Isslocator\Http;

interface Client
{
    const RESPONSE_CODE_SUCCESS = 200;

    const REQUEST_METHOD_GET = 'GET';

    /**
     * Sends http request
     *
     * @param string $method Http method
     * @param string $uri JSON api endpoint
     * @param array $options
     * @return array Associative array containing decoded response body
     */
    public function request(string $method, string $uri = '', array $options = []):array;
}
