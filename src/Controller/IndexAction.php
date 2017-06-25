<?php

declare(strict_types = 1);

namespace Isslocator\Controller;

use Isslocator\Template\Renderer;

class IndexAction
{
    /**
     * @var Renderer
     */
    private $renderer;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Executes the action and returns response content
     *
     * @return string
     */
    public function execute()
    {
        return $this->renderer->render('index.html', [
            'location' => __METHOD__
        ]);
    }
}
