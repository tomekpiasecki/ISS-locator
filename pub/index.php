<?php

declare(strict_types = 1);

use Auryn\Injector;
use FastRoute\Dispatcher;
use Isslocator\Controller\IndexAction;

define('DS', DIRECTORY_SEPARATOR);

/** @var Injector  $container */
$diContainer = require __DIR__ . DS . '..' . DS . 'app' . DS . 'boostrap.php';

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', [IndexAction::class, 'execute']);
});

$routeInfo = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        header("HTTP/1.1 404 Not Found");
        echo '<h1>Not found</h1>';
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        header("HTTP/1.1 405 Method Not Allowed");
        echo '<h1>Method not allowed</h1>';
        break;
    case Dispatcher::FOUND:
        $className = $routeInfo[1][0];
        $method = $routeInfo[1][1];
        $parameters = $routeInfo[2];

        $class = $diContainer->make($className);
        $response = $class->$method($parameters);
        header("HTTP/1.1 200 OK");
        echo $response;
        break;
}