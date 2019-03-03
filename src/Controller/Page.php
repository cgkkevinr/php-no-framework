<?php
declare(strict_types=1);

namespace App\Controller;

use App\Page\PageException;
use App\Page\PageReader;
use App\Template\FrontendRenderer;
use Symfony\Component\HttpFoundation\Response;

class Page
{
    /**
     * @var PageReader
     */
    private $reader;
    /**
     * @var FrontendRenderer
     */
    private $renderer;
    /**
     * @var Response
     */
    private $response;

    public function __construct(PageReader $reader, FrontendRenderer $renderer, Response $response)
    {
        $this->reader = $reader;
        $this->renderer = $renderer;
        $this->response = $response;
    }

    public function show($params)
    {
        $slug = $params['slug'];

        try {
            $data = $this->reader->readBySlug($slug);
        } catch (PageException $exception) {
            $this->response->setStatusCode(404);
            return $this->response->setContent("Page `$slug` not found.");
        }

        $content = $this->renderer->render('page', ['content' => $data]);
        return $this->response->setContent($content);
    }
}