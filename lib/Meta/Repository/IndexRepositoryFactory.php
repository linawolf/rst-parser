<?php

declare(strict_types=1);

namespace Doctrine\RST\Meta\Repository;

class IndexRepositoryFactory
{
    private ?IndexRepository $indexRepository = null;

    public function getIndexRepository(): IndexRepository
    {
        if ($this->indexRepository === null) {
            $this->indexRepository = new IndexRepository();
        }

        return $this->indexRepository;
    }
}
