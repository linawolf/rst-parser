<?php

declare(strict_types=1);

namespace Doctrine\Tests\RST\BuilderDuplicateAnchorsInTwoFiles;

use Doctrine\RST\Builder;
use Doctrine\RST\Configuration;
use Doctrine\RST\ErrorManager;
use Doctrine\RST\Kernel;
use Doctrine\Tests\RST\BaseBuilderTest;
use PHPUnit\Framework\MockObject\MockObject;

class BuilderDuplicateAnchorsInTwoFilesTest extends BaseBuilderTest
{
    private Configuration $configuration;

    /** @var ErrorManager|MockObject */
    private $errorManager;

    protected function setUp(): void
    {
        $this->configuration = new Configuration();
        $this->configuration->setUseCachedMetas(false);

        $this->errorManager = $this->createMock(ErrorManager::class);
        $this->builder      = new Builder(new Kernel($this->configuration), $this->errorManager);
    }

    public function testDuplicateReferenceSetsWarning(): void
    {
        $this->errorManager->expects(self::atLeastOnce())->method('warning');
        $this->builder->build($this->sourceFile(), $this->targetFile());
    }

    public function testInvalidReferenceRenamed(): void
    {
        $this->configuration->setIgnoreInvalidReferences(true);

        $this->builder->build($this->sourceFile(), $this->targetFile());

        // One of the two anchors has to be renamed. It does not matter which one
        $contents  = $this->getFileContents($this->targetFile('duplicateAnchor.html'));
        $contents .= $this->getFileContents($this->targetFile('index.html'));

        self::assertStringContainsString(' id="an-anchor-2"', $contents);
    }

    protected function getFixturesDirectory(): string
    {
        return 'BuilderDuplicateAnchorsInTwoFiles';
    }
}
