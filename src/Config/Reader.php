<?php

declare(strict_types = 1);

namespace Isslocator\Config;

interface Reader {
    /**
     * Retrieves param value from configuration
     *
     * @param string $param
     * @return string|null
     */
    public function get(string $param = '');
}
