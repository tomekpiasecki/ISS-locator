<?php

declare(strict_types = 1);

use Auryn\Injector as DiContainer;
use Isslocator\Config\Reader as ConfigReaderInterface;
use Isslocator\Config\FileReader as FileConfigReader;
use Isslocator\Http\Client as HttpClient;
use Isslocator\Http\GuzzleClient;
use Isslocator\Http\Request as RequestInterface;
use Isslocator\Http\Response as ResponseInterface;
use Isslocator\Location\Coordinates\IssRetriever as IssCoordinatesRetriever;
use Isslocator\Location\Coordinates\Retriever as CoordinatesRetriever;
use Isslocator\Location\IssRetriever;
use Isslocator\Location\Retriever as LocationRetriever;
use Isslocator\Location\Reverse\Geocoder;
use Isslocator\Location\Reverse\GoogleGeocoder;
use Isslocator\Template\Renderer;
use Isslocator\Template\TwigRenderer;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Request as RequestImplementation;
use Symfony\Component\HttpFoundation\Response as ResponseImplementation;

error_reporting(E_ALL);

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

require dirname(__DIR__) . DS . "vendor" . DS . "autoload.php";

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

$diContainer->alias(ConfigReaderInterface::class, FileConfigReader::class);
$diContainer->share(FileConfigReader::class);
$diContainer->define(FileConfigReader::class, [
    ':configPath' => dirname(__DIR__) . DS . 'app' . DS . 'etc' . DS . 'config.ini'
]);

$diContainer->alias(LocationRetriever::class, IssRetriever::class);
$diContainer->alias(CoordinatesRetriever::class, IssCoordinatesRetriever::class);
$diContainer->alias(Geocoder::class, GoogleGeocoder::class);
$diContainer->alias(HttpClient::class, GuzzleClient::class);

$diContainer->define(Logger::class, [
    ':name' => 'iss_logger'
]);
$diContainer->prepare(Logger::class, function ($myObject, $container) {
    $myObject->pushHandler(new StreamHandler(dirname(__DIR__) . DS . 'var' . DS . 'app.log', \Monolog\Logger::DEBUG));
});

return $diContainer;
