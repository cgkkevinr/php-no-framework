<?php
declare(strict_types=1);

$injector = new \Auryn\Injector;

$injector->define(\Symfony\Component\HttpFoundation\Request::class, [
    $_GET, $_POST, [], $_COOKIE, $_FILES, $_SERVER
]);

$injector->share(\Symfony\Component\HttpFoundation\Request::class);
$injector->share(\Symfony\Component\HttpFoundation\Response::class);

return $injector;