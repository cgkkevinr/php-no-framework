<?php
declare(strict_types=1);

namespace App\Controller;

use App\Template\Renderer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Home
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var Response
     */
    private $response;
    /**
     * @var Renderer
     */
    private $renderer;

    public function __construct(Request $request, Response $response, Renderer $renderer)
    {
        $this->request = $request;
        $this->response = $response;
        $this->renderer = $renderer;
    }

    public function show()
    {
        $data = ['name' => $this->request->query->get('name', 'stranger')];
        $content = $this->renderer->render('index.html.twig', $data);
        return $this->response->setContent($content);
    }
}