<?php

declare(strict_types=1);

namespace Doctrine\RST\Builder;

use Doctrine\RST\Configuration;
use Doctrine\RST\Renderers\FullDocumentNodeRenderer;
use Doctrine\RST\Renderers\FullGeneralIndexRenderer;
use Symfony\Component\Filesystem\Filesystem;

class GeneralIndex
{
    private Filesystem $filesystem;

    public function __construct(
        Configuration $configuration,
        Filesystem $filesystem
    )
    {
        $this->configuration = $configuration;
        $this->filesystem = $filesystem;
    }


    public function render(string $targetDirectory): void
    {
        $renderer = $this->configuration->getGeneralIndexRenderer();
        if ($renderer === null) {
            // If there is no renderer the general index does not get rendered, for example in LATEX
            return;
        }
        $content = $renderer->render();
        $this->filesystem->dumpFile($targetDirectory . '/' . $this->configuration->getGeneralIndexFile() . '.' . $this->configuration->getFileExtension(), $content);
    }
}
