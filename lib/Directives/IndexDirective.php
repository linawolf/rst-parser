<?php

declare(strict_types=1);

namespace Doctrine\RST\Directives;

use Doctrine\RST\Meta\Repository\IndexRepository;
use Doctrine\RST\Nodes\Node;
use Doctrine\RST\Parser;

class IndexDirective extends SubDirective
{
    private IndexRepository $indexRepository;

    public function __construct(IndexRepository $indexRepository)
    {
        $this->indexRepository = $indexRepository;
    }

    public function getName(): string
    {
        return 'index';
    }

    /** @param string[] $options */
    public function processSub(
        Parser $parser,
        ?Node $document,
        string $variable,
        string $data,
        array $options
    ): ?Node {
        $this->indexRepository->addTextAsIndex($data);

        // Indexes do not get rendered within their document
        return null;
    }
}
