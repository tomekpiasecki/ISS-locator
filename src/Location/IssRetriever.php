<?php

declare(strict_types = 1);

namespace Isslocator\Location;

use Isslocator\Location\Coordinates\Retriever as CoordinatesRetriever;
use Isslocator\Location\Reverse\Geocoder;

class IssRetriever implements Retriever
{
    /**
     * @var string
     */
    private $humanReadableMessage = 'The ISS is currently over %s';

    /**
     * @var string
     */
    private $coordinatesMessage = <<<MESSAGE
Current coordinates of the ISS position are latitude: %s, longitude: %s. We were not able to retrieve human readable location so it's probably over an ocean. Please try again later.
MESSAGE;


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
        $coordinates = $this->coordinatesRetriever->retrieveCoordinates();
        $humanReadableLocation = $this->geocoder->geocode($coordinates);

        return $humanReadableLocation !== '' ?
            sprintf($this->humanReadableMessage, $humanReadableLocation) :
            sprintf($this->coordinatesMessage, $coordinates->getLatitude(), $coordinates->getLongitude());
    }
}
