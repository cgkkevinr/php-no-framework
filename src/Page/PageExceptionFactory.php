<?php
declare(strict_types=1);

namespace App\Page;

class PageExceptionFactory
{
    public function createPageNotFound(string $slug)
    {
        return new PageException("No page with the slug `$slug` could be found.");
    }
}