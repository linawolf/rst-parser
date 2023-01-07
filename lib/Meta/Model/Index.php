<?php

declare(strict_types=1);

namespace Doctrine\RST\Meta\Model;

class Index
{
    private string $chapter;
    private string $entry;
    private bool $important = false;
    private string $url;


    public function __construct(
        string $chapter = '',
        string $entry = '',
        string $url = '',
        bool $important = false
    ) {
        $this->chapter   = $chapter;
        $this->entry     = $entry;
        $this->important = $important;
        $this->url       = $url;
    }

    public function getChapter(): string
    {
        return $this->chapter;
    }

    public function getEntry(): string
    {
        return $this->entry;
    }

    public function isImportant(): bool
    {
        return $this->important;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $chapter
     */
    public function setChapter(string $chapter): void
    {
        $this->chapter = $chapter;
    }

    /**
     * @param string $entry
     */
    public function setEntry(string $entry): void
    {
        $this->entry = $entry;
    }

    /**
     * @param bool $important
     */
    public function setImportant(bool $important): void
    {
        $this->important = $important;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}
