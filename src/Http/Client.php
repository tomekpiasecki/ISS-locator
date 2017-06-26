<?php

declare(strict_types = 1);

namespace Isslocator\Http;

interface Client
{
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
