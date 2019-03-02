<?php
declare(strict_types=1);

namespace App\Template;

use Twig\Environment;

class TwigRenderer implements Renderer
{
    /**
     * @var Environment
     */
    private $engine;

    public function __construct(Environment $engine)
    {
        $this->engine = $engine;
    }

    public function render($template, $data = []): string
    {
        return $this->engine->render($template, $data);
    }
}