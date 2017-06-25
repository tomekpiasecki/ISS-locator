<?php

declare(strict_types = 1);

use Auryn\Injector as DiContainer;
use Isslocator\Http\Request as RequestInterface;
use Isslocator\Http\Response as ResponseInterface;
use Isslocator\Template\Renderer;
use Isslocator\Template\TwigRenderer;
use Symfony\Component\HttpFoundation\Request as RequestImplementation;
use Symfony\Component\HttpFoundation\Response as ResponseImplementation;

error_reporting(E_ALL);

//TODO remove
ini_set('display_errors', '1');

require __DIR__ . DS . '..' . DS . "vendor" . DS . "autoload.php";

$diContainer = new DiContainer;

$diContainer->alias(RequestInterface::class, RequestImplementation::class);
$diContainer->share(RequestImplementation::class);
$diContainer->define(RequestImplementation::class, [
    $_GET,
    $_POST,
    [],
    $_COOKIE,
    $_FILES,
    $_SERVER
]);

$diContainer->alias(ResponseInterface::class, ResponseImplementation::class);
$diContainer->share(ResponseImplementation::class);

$diContainer->alias(Renderer::class, TwigRenderer::class);
$diContainer->define(Twig_Environment::class, [
    ':loader' => new Twig_Loader_Filesystem(dirname(__DIR__) . DS . 'templates')
]);

return $diContainer;
