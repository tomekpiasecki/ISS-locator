<?php

declare(strict_types = 1);

namespace Isslocator\Http;

interface Client
{
    /**
     * Sends http request
     *
     * @param string $method Http method
     * @param string $uri
     * @param array $options
     * @return mixed
     */
    public function request(string $method, string $uri = '', array $options = []);
}
