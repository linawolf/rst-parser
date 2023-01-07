<?php

declare(strict_types=1);

namespace Doctrine\RST\Meta\Repository;

use Doctrine\RST\Configuration;
use Doctrine\RST\ErrorManager;
use Doctrine\RST\Meta\Model\Index;

use function strtolower;
use function usort;

class IndexRepository
{
    /** @var array<String,<String, Index>> */
    private array $indexArray = [];
    private const INDEX_MODE_SINGLE = 'single';
    private const INDEX_MODE_PAIR = 'pair';
    private const INDEX_MODE_TRIPPLE = 'tripple';
    private const INDEX_MODE_SEE = 'see';
    private const INDEX_MODE_SEEALSO = 'seealso';

    private Configuration $configuration;

    /**
     * @param Configuration $configuration
     */
    public function __construct(ErrorManager $errorManager)
    {
        $this->errorManager = $errorManager;
    }

    public function addTextAsIndex(string $originalText, string $url): void
    {
    }

    public function addIndex(Index $index) {
        $this->indexArray[$index->getChapter()][$index->getEntry()][] = $index;
    }

    /** @return array<String,<String, Index>> */
    public function getIndexArray(): array
    {
        //usort($this->indexArray, [$this, 'compare']);

        return $this->indexArray;
    }

    public function compare(Index $a, Index $b): int
    {
        return strtolower($a->getChapter() . $a->getChapter()) <=> strtolower($b->getChapter() . $b->getChapter());
    }
}
