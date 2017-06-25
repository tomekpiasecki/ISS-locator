<?php

declare(strict_types = 1);

namespace Isslocator\Location;

class Coordinates
{
    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    public function __construct(float $latitude, float $longitude)
    {

        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * Returns coordinates latitude
     *
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * Returns coordinates longitude
     *
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

}
