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
        $text = trim($originalText);
        $mode = self::INDEX_MODE_SINGLE;
        $important = false;
        if (strpos($text, '!') === 0) {
            $important = true;
            $text = substr($text, 1);
        }
        if (str_contains($text, ':')) {
            $parts = explode(':', $text, 2);
            $mode = trim(strtolower($parts[0]));
            $text = trim($parts[1]);
        }
        $entryParts = explode(';', $text, 2);
        foreach ($entryParts as $key=>$part) {
            $entryParts[$key] = trim($part);
        }
        switch ($mode) {
            case self::INDEX_MODE_SINGLE:
                if (count($entryParts) < 2) {
                    $this->addIndex(new Index($entryParts[0], '', $url, $important));
                } else {
                    $this->addIndex(new Index($entryParts[0],
                        $entryParts[1], $url, $important));
                    break;
                }
            case self::INDEX_MODE_PAIR:
                if (count($entryParts) !== 2) {
                    $this->errorManager->warning('Index of mode "pair:" expects exactly 2 entries.');
                    return;
                }
                $this->addIndex(new Index($entryParts[0],
                    $entryParts[1], $url, $important));
                $this->addIndex(new Index($entryParts[1],
                    $entryParts[0], $url, $important));
                break;
            case self::INDEX_MODE_TRIPPLE:
                if (count($entryParts) !== 3) {
                    $this->errorManager->warning('Index of mode "tripple:" expects exactly 3 entries.');
                    return;
                }
                $this->addIndex(new Index($entryParts[0],
                    $entryParts[1], $url, $important));
                $this->addIndex(new Index($entryParts[1],
                    $entryParts[0], $url, $important));
                $this->addIndex(new Index($entryParts[0],
                    $entryParts[2], $url, $important));
                $this->addIndex(new Index($entryParts[2],
                    $entryParts[0], $url, $important));
                $this->addIndex(new Index($entryParts[1],
                    $entryParts[2], $url, $important));
                $this->addIndex(new Index($entryParts[2],
                    $entryParts[1], $url, $important));
                break;
            default:
                $this->errorManager->warning('Index mode ' . $mode . ' is not supported');
                return;
        }
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
