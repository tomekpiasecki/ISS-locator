<?php

declare(strict_types = 1);

namespace Isslocator\Http;

interface Response
{
    public function prepare(Request $request):Response;
    public function sendHeaders();
    public function sendContent();
    public function send();
    public function setContent($content);
    public function getContent();
    public function getStatusCode();
    public function setStatusCode($code, $text = null);
}