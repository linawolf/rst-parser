<?php

declare(strict_types=1);

namespace Doctrine\RST\Meta\Repository;

use Doctrine\RST\Configuration;
use Doctrine\RST\ErrorManager;

class IndexRepositoryFactory
{
    private ?IndexRepository $indexRepository = null;

    private ErrorManager $errorManager;

    /**
     * @param Configuration $errorManager
     */
    public function __construct(ErrorManager $errorManager)
    {
        $this->errorManager = $errorManager;
    }


    public function getIndexRepository(): IndexRepository
    {
        if ($this->indexRepository === null) {
            $this->indexRepository = new IndexRepository($this->errorManager);
        }

        return $this->indexRepository;
    }
}
