<?php
declare(strict_types=1);

return [
    ['GET', '/', [\App\Controller\Home::class, 'show']],
    ['GET', '/hello-world', function () {
        echo 'Hello World!';
    }],
    ['GET', '/another-route', function () {
        echo 'This works too!';
    }],
];