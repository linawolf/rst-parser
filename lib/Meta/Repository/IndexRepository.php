<?php

declare(strict_types=1);

namespace Doctrine\RST\Meta\Repository;

use Doctrine\RST\Meta\Model\Index;

use function strtolower;
use function usort;

class IndexRepository
{
    /** @var Index[] */
    private array $indexArray = [];

    public function addTextAsIndex(string $text): void
    {
    }

    /** @return Index[] */
    public function getIndexArray(): array
    {
        usort($this->indexArray, [$this, 'compare']);

        return $this->indexArray;
    }

    public static function compare(Index $a, Index $b): int
    {
        return strtolower($a->getChapter() . $a->getChapter()) <=> strtolower($b->getChapter() . $b->getChapter());
    }
}
