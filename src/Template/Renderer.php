<?php

declare(strict_types = 1);

namespace Isslocator\Template;

interface Renderer {
    public function render(string $template, array $data = []) : string;
}
