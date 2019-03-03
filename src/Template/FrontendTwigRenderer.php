<?php
declare(strict_types=1);

namespace App\Template;

use App\Menu\MenuReader;

class FrontendTwigRenderer implements FrontendRenderer
{
    /**
     * @var Renderer
     */
    private $renderer;
    /**
     * @var MenuReader
     */
    private $menuReader;

    public function __construct(Renderer $renderer, MenuReader $menuReader)
    {
        $this->renderer = $renderer;
        $this->menuReader = $menuReader;
    }

    public function render($template, $data = []): string
    {
        $default = [
            'menuItems' => $this->menuReader->readMenu()
        ];

        $data = \array_merge($default, $data);
        return $this->renderer->render($template, $data);
    }
}