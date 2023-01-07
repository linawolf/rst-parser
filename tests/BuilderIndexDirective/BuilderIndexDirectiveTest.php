<?php

declare(strict_types=1);

namespace Doctrine\Tests\RST\BuilderIndexDirective;

use Doctrine\RST\Builder;
use Doctrine\RST\Configuration;
use Doctrine\Tests\RST\BaseBuilderTest;

/**
 * Tests a custom Finder for Scanner
 */
class BuilderIndexDirectiveTest extends BaseBuilderTest
{
    /** @var Configuration */
    private $configuration;

    protected function setUp(): void
    {
        $this->configuration = new Configuration();
        $this->configuration->setUseCachedMetas(false);
        $this->configuration->silentOnError(true);

        $this->builder = new Builder();
        $this->builder->build($this->sourceFile(), $this->targetFile());
    }


    public function testDocumentIndexIsGenerated(): void
    {
        $this->getFileContents($this->targetFile('index.html'));
        self::assertFileExists($this->targetFile('genindex.html'));
    }

    public function testDocumentWithIndexGetsBuild(): void
    {
        $contents = $this->getFileContents($this->targetFile('index.html'));
        self::assertStringContainsString('<h1>Index</h1>', $contents);
    }

    protected function getFixturesDirectory(): string
    {
        return 'BuilderIndexDirective';
    }
}
