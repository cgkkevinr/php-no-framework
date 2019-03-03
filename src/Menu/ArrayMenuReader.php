<?php
declare(strict_types=1);

namespace App\Menu;

class ArrayMenuReader implements MenuReader
{
    public function readMenu(): array
    {
        return [
            ['href' => '/', 'text' => 'Homepage'],
            ['href' => '/hello-world', 'text' => 'Hello World!'],
            ['href' => '/another-one', 'text' => 'Another One'],
            ['href' => '/page/article01', 'text' => 'Article01']
        ];
    }
}