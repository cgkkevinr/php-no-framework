<?php
declare(strict_types=1);

namespace App\Page;

class FilePageReader implements PageReader
{
    /**
     * @var array|null
     */
    private $options;
    /**
     * @var PageExceptionFactory
     */
    private $exceptionFactory;

    public function __construct(?array $options = null, PageExceptionFactory $exceptionFactory)
    {
        $this->options = \array_merge($this->getDefaults(), $options);
        $this->exceptionFactory = $exceptionFactory;
    }

    private function getDefaults(): array
    {
        return [
            'pages' => __DIR__
        ];
    }

    private function getPagesLocation(): string
    {
        return $this->options['pages'];
    }

    public function readBySlug(string $slug): string
    {
        $fileName = $this->getPagesLocation() . $slug . '.md';

        if (file_exists($fileName) === false) {
            throw $this->exceptionFactory->createPageNotFound($slug);
        }

        return file_get_contents($fileName);
    }
}