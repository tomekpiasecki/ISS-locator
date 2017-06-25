<?php

declare(strict_types = 1);

use Auryn\Injector;
use FastRoute\Dispatcher;
use Isslocator\Controller\IndexAction;
use Isslocator\Http\Request;
use Isslocator\Http\Response;

define('DS', DIRECTORY_SEPARATOR);

/** @var Injector  $container */
$diContainer = require __DIR__ . DS . '..' . DS . 'app' . DS . 'boostrap.php';

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', [IndexAction::class, 'execute']);
});

/** @var Request $request */
$request = $diContainer->make(Request::class);
/** @var Response $response */
$response = $diContainer->make(Response::class);

$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getRequestUri());
switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        $response->setStatusCode(404);
        $response->setContent('<h1>Not found</h1>');
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        $response->setStatusCode(405);
        $response->setContent('<h1>Method not allowed</h1>');
        break;
    case Dispatcher::FOUND:
        $className = $routeInfo[1][0];
        $method = $routeInfo[1][1];
        $parameters = $routeInfo[2];

        $class = $diContainer->make($className);
        $content = $class->$method($parameters);

        $response->setStatusCode(200);
        $response->setContent($content);
        break;
}

$response->prepare($request);
$response->send();
