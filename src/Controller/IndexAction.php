<?php

declare(strict_types = 1);

namespace Isslocator\Controller;

use Isslocator\Location\Retriever;
use Isslocator\Template\Renderer;

class IndexAction
{
    /**
     * @var Renderer
     */
    private $renderer;

    /**
     * @var Retriever
     */
    private $locationRetriever;

    public function __construct(Renderer $renderer, Retriever $locationRetriever)
    {
        $this->renderer = $renderer;
        $this->locationRetriever = $locationRetriever;
    }

    /**
     * Executes the action and returns response content
     *
     * @return string
     */
    public function execute()
    {
        return $this->renderer->render('index.html', [
            'location' => $this->locationRetriever->retrieveLocation()
        ]);
    }
}
