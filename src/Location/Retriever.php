<?php

declare(strict_types = 1);

namespace Isslocator\Location;

interface Retriever {
    /**
     * Retrieves current location of ISS in human readable format
     *
     * @return string
     */
    public function retrieveLocation():string;
}
