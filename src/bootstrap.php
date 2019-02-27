<?php
declare(strict_types=1);

namespace App;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;
use Nette\Http\RequestFactory;
use Nette\Http\Response;
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

$request = (new RequestFactory())->createHttpRequest();
$response = new Response;

$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getUrl()->getPath());
switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        $response->setCode(404);
        $response->setContentType('text/plain', 'UTF-8');
        echo '404 - Page Not Found: ' . PHP_EOL;
        echo 'Path: ' . $request->getUrl()->getPath() . PHP_EOL;
        echo 'Path Info: ' . $request->getUrl()->getPathInfo() . PHP_EOL;
        echo 'Relative URL: ' . $request->getUrl()->getRelativeUrl() . PHP_EOL;
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        $response->setCode(405);
        echo '405 - Method Not Allowed';
        break;
    case Dispatcher::FOUND:
        $vars = $routeInfo[2];

        if (is_array($routeInfo[1])) {
            $className = $routeInfo[1][0];
            $method = $routeInfo[1][1];
            $class = new $className;
            $class->$method($vars);
            break;
        }

        $handler = $routeInfo[1];
        call_user_func($handler, $vars);
        break;
}