<?php

declare(strict_types = 1);

namespace Isslocator\Http;

interface Request
{
    public function get($key, $default = null);
    public function getPathInfo():string;
    public function getRequestUri():string;
    public function getMethod():string;
    public function getContentType();
}
