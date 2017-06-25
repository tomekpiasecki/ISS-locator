<?php

declare(strict_types = 1);

namespace Isslocator\Location\Reverse;

use Isslocator\Location\Coordinates;

interface Geocoder {
    /**
     * Geocodes coordinates to human readable address
     *
     * @return string
     */
    public function geocode(Coordinates $coordinates):string;
}
