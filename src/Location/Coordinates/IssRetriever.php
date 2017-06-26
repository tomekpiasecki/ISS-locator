<?php

declare(strict_types = 1);

namespace Isslocator\Location\Coordinates;

use Isslocator\Exception\CoordinatesException;
use Isslocator\Http\Client as HttpClient;
use Isslocator\Location\Coordinates;

class IssRetriever implements Retriever
{
    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var string
     */
    private $satelliteId = '25544';

    /**
     * @var string
     */
    private $endpointUrl = 'https://api.wheretheiss.at/v1/satellites/%s';

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Retrieves current coordinates of ISS station
     *
     * @return Coordinates
     * @throws CoordinatesException
     */
    public function retrieveCoordinates(): Coordinates
    {
        $uri = $this->getEndpointUrl();
        try {
            $response = $this->httpClient->request(HttpClient::REQUEST_METHOD_GET, $uri);
            if (!isset($response['latitude']) || !isset($response['longitude'])) {
                throw new \RuntimeException("Incomplete response received from $uri " . print_r($response, true));
            }
        } catch (\Throwable $ex) {
            throw new CoordinatesException("Failed to retrieve coordinates", 0, $ex);
        }

        return new Coordinates($response['latitude'], $response['longitude']);
    }

    /**
     * @return string
     */
    protected function getEndpointUrl():string
    {
        return sprintf($this->endpointUrl, $this->getSatelliteId());
    }

    /**
     * @return string
     */
    protected function getSatelliteId():string
    {
        return $this->satelliteId;
    }
}
