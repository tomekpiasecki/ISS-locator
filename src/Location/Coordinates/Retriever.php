<?php

declare(strict_types = 1);

namespace Isslocator\Location\Coordinates;

use Isslocator\Location\Coordinates;

interface Retriever {
    /**
     * Retrieves current coordinates of ISS station
     *
     * @return Coordinates
     */
    public function retrieveCoordinates():Coordinates;
}
