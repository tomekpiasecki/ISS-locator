<?php

declare(strict_types = 1);

namespace Isslocator\Template;

class TwigRenderer implements Renderer
{
    /**
     * @var \Twig_Environment
     */
    private $renderer;

    /**
     * @param \Twig_Environment $renderer
     */
    public function __construct(\Twig_Environment $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Renders a template.
     *
     * @param string $template The template name
     * @param array  $data An array of parameters to pass to the template
     *
     * @return string The rendered template
     */
    public function render(string $template, array $data = []): string
    {
        return $this->renderer->render($template, $data);
    }
}
