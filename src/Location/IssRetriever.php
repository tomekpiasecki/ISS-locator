<?php

declare(strict_types = 1);

namespace Isslocator\Location;

use Isslocator\Location\Coordinates\Retriever as CoordinatesRetriever;
use Isslocator\Location\Reverse\Geocoder;

class IssRetriever implements Retriever
{
    /**
     * @var CoordinatesRetriever
     */
    private $coordinatesRetriever;

    /**
     * @var Geocoder
     */
    private $geocoder;

    public function __construct(CoordinatesRetriever $coordinatesRetriever, Geocoder $geocoder)
    {
        $this->coordinatesRetriever = $coordinatesRetriever;
        $this->geocoder = $geocoder;
    }

    /**
     * @inheritdoc
     */
    public function retrieveLocation(): string
    {
        return $this->geocoder->geocode($this->coordinatesRetriever->retrieveCoordinates());
    }
}
