<?php

declare(strict_types=1);

namespace Doctrine\RST\Nodes;

final class IndexNode extends Node
{
    /** @var String[] */
    private array $entries;
    private string $url;
    private string $mode;
    private bool $important;

    public const INDEX_MODE_SINGLE = 'single';
    public const INDEX_MODE_PAIR = 'pair';
    public const INDEX_MODE_TRIPPLE = 'tripple';
    public const INDEX_MODE_SEE = 'see';
    public const INDEX_MODE_SEEALSO = 'seealso';


    public function __construct(
        array $entries,
        string $url = '',
        string $mode = self::INDEX_MODE_SINGLE,
        bool $important = false
    ) {
        parent::__construct();
        $this->entries = $entries;
        $this->important = $important;
        $this->url = $url;
        $this->mode = $mode;
    }

}