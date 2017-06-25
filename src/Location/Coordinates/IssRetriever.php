<?php

declare(strict_types = 1);

namespace Isslocator\Location\Coordinates;

use Isslocator\Location\Coordinates;

class IssRetriever implements Retriever
{
    /**
     * @inheritdoc
     */
    public function retrieveCoordinates(): Coordinates
    {
        return new Coordinates(-25.346134802867,18.047422455202);
    }
}
