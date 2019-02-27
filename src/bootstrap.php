<?php
declare(strict_types=1);

namespace App;

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

$request = (new RequestFactory())->createHttpRequest();
$response = new Response();

$response->setCode(500);
$response->setContentType('text/plain', 'UTF-8');

foreach ($response->getHeaders() as $header) {
    header($header, false);
}

echo 'Hello: ' . $request->getRemoteAddress() . PHP_EOL;
echo 'QueryParams:' . PHP_EOL;
foreach ($request->getQuery() as $key => $value) {
    echo '    ' . $key . ' => ' . $value . PHP_EOL;
}