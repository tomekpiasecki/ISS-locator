<?php

declare(strict_types = 1);

namespace Isslocator\Location\Reverse;

use Isslocator\Location\Coordinates;

class GoogleGeocoder implements Geocoder
{
    /**
     * @inheritdoc
     */
    public function geocode(Coordinates $coordinates): string
    {
        return date('d-m-Y H:i:s') . ' ' . $coordinates->getLatitude() . ' ' . $coordinates->getLongitude();
    }
}
