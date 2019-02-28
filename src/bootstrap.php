<?php
declare(strict_types=1);

namespace App;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

require __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);

$environment = 'development';

/**
 * Register the error handler
 */
$whoops = new Run;

if ($environment !== 'production') {
    $whoops->pushHandler(new PrettyPageHandler);
} else {
    $whoops->pushHandler(function (\Throwable $exception) {
        echo 'Error! Something went horribly wrong: ' . $exception->getMessage();
        echo PHP_EOL;
        echo 'Todo: Friendly error page and send an e-mail to the developer';
        echo PHP_EOL;
    });
}

$whoops->register();

$routesCallback = function (RouteCollector $collector) {
    $routes = include('routes.php');
    foreach ($routes as $route) {
        $collector->addRoute($route[0], $route[1], $route[2]);
    }
};

$dispatcher = simpleDispatcher($routesCallback);

$injector = include('dependencies.php');

$request = $injector->make(Request::class);
$response = $injector->make(Response::class);

$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());
switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        $response->setStatusCode(404);
        $response->headers->set('Content-Type', 'text/plain; charset=UTF-8');
        $content  = '404 - Page Not Found' . PHP_EOL;
        $content .= 'Path: ' . $request->getPathInfo() . PHP_EOL;
        $response->setContent($content);
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        $response->setStatusCode(405);
        $response->setContent('405 - Method Not Allowed');
        break;
    case Dispatcher::FOUND:
        $vars = $routeInfo[2];

        if (is_array($routeInfo[1])) {
            $className = $routeInfo[1][0];
            $method = $routeInfo[1][1];
            $class = $injector->make($className);
            $class->$method($vars);
            break;
        }

        $handler = $routeInfo[1];
        call_user_func($handler, $vars);
        break;
}

$response->send();