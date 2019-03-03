<?php
declare(strict_types=1);

namespace App\Template;

class FrontendTwigRenderer implements FrontendRenderer
{
    /**
     * @var Renderer
     */
    private $renderer;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function render($template, $data = []): string
    {
        $default = [
            'menuItems' => [
                ['href' => '/', 'text' => 'Homepage']
            ]
        ];

        $data = \array_merge($default, $data);
        return $this->renderer->render($template, $data);
    }
}