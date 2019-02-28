<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class Home
{
    /**
     * @var Response
     */
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function show()
    {
        return $this->response->setContent('Hello World!');
    }
}