<?php
declare(strict_types=1);

$injector = new \Auryn\Injector;

$injector->define(\Symfony\Component\HttpFoundation\Request::class, [
    $_GET, $_POST, [], $_COOKIE, $_FILES, $_SERVER
]);

$injector->share(\Symfony\Component\HttpFoundation\Request::class);
$injector->share(\Symfony\Component\HttpFoundation\Response::class);

$injector->define(\App\Template\TwigRenderer::class, [
    new \Twig\Environment(
        new \Twig\Loader\FilesystemLoader(
            __DIR__ . '/../templates/'
        ),
        [
            'cache' => __DIR__ . '/../var/cache/twig/'
        ]
    )
]);
$injector->alias(\App\Template\Renderer::class, \App\Template\TwigRenderer::class);

return $injector;