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

$injector->define(\App\Page\FilePageReader::class, [
    [
        'pages' => __DIR__ . '/../pages/'
    ]
]);

$injector->alias(\App\Template\Renderer::class, \App\Template\TwigRenderer::class);
$injector->alias(\App\Template\FrontendRenderer::class, \App\Template\FrontendTwigRenderer::class);
$injector->alias(\App\Page\PageReader::class, \App\Page\FilePageReader::class);
$injector->alias(\App\Menu\MenuReader::class, \App\Menu\ArrayMenuReader::class);

$injector->share(\App\Template\TwigRenderer::class);
$injector->share(\App\Page\FilePageReader::class);
$injector->share(\App\Menu\ArrayMenuReader::class);

return $injector;