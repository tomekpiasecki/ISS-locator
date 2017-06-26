<?php

declare(strict_types = 1);

namespace Isslocator\Location\Reverse;

use Isslocator\Config\Reader as ConfigReader;
use Isslocator\Exception\GeocoderException;
use Isslocator\Http\Client as HttpClient;
use Isslocator\Location\Coordinates;

class GoogleGeocoder implements Geocoder
{
    const RESPONSE_STATUS_SUCCESS = 'OK';
    const RESPONSE_STATUS_ZERO_RESULTS = 'ZERO_RESULTS';

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var string
     */
    private $mapsApiKeyConfigParam = 'maps_api_key';

    /**
     * @var string
     */
    private $endpointUrl = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=%s,%s&key=%s';

    /**
     * @var array
     */
    protected $response = [];

    /**
     * @var ConfigReader
     */
    private $config;

    public function __construct(HttpClient $httpClient, ConfigReader $config)
    {
        $this->httpClient = $httpClient;
        $this->config = $config;
    }

    /**
     * Geocodes coordinates to human readable address
     *
     * @return string
     * @throws GeocoderException
     */
    public function geocode(Coordinates $coordinates): string
    {
        $uri = $this->getEndpointUrl($coordinates->getLatitude(), $coordinates->getLongitude());

        try {
            $this->response = $this->httpClient->request(HttpClient::REQUEST_METHOD_GET, $uri);

            if ($this->response['status'] !== self::RESPONSE_STATUS_SUCCESS &&
                $this->response['status'] !== self::RESPONSE_STATUS_ZERO_RESULTS
            ) {
                throw new \RuntimeException("Request to $uri completed with status {$this->response['status']}");
            }
        } catch (\Throwable $ex) {
            throw new GeocoderException(
                "Failed to retrieve location for {$coordinates->getLatitude()} {$coordinates->getLongitude()}",
                0,
                $ex
            );
        }

        return $this->extractLocationFromResponse();
    }

    /**
     * Extract human readable address from api response
     *
     * @return string
     */
    protected function extractLocationFromResponse():string
    {
        if (!isset($this->response['results']) ||
            !is_array($this->response['results']) ||
            !isset($this->response['results'][0]) ||
            !is_array($this->response['results'][0]) ||
            !isset($this->response['results'][0]['formatted_address'])
        ) {
            return '';
        }

        return $this->response['results'][0]['formatted_address'];
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @return string
     */
    protected function getEndpointUrl(float $latitude, float $longitude):string
    {
        return sprintf($this->endpointUrl, $latitude, $longitude, $this->getMapsApiKey());
    }

    /**
     * @return string
     */
    protected function getMapsApiKey():string
    {
        return $this->config->get($this->mapsApiKeyConfigParam);
    }
}
