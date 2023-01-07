<?php

declare(strict_types=1);

namespace Doctrine\RST\Directives;

use Doctrine\RST\Meta\Repository\IndexRepository;
use Doctrine\RST\Nodes\Node;
use Doctrine\RST\Parser;

class IndexDirective extends Directive
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

    public function processNode(Parser $parser, string $variable, string $data, array $options): ?Node
    {
        if ($data !== '') {
            $this->indexRepository->addTextAsIndex($data);
        }
        return null;
    }
}
