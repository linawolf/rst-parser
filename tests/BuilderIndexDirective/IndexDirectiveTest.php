<?php

declare(strict_types=1);

namespace Doctrine\Tests\RST\BuilderIndexDirective;

use Doctrine\RST\Directives\IndexDirective;
use Doctrine\RST\Meta\Repository\IndexRepository;
use Doctrine\RST\Parser;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Tests a custom Finder for Scanner
 */
class IndexDirectiveTest extends TestCase
{
    /** @var Parser|MockObject */
    private $parser;
    /** @var IndexRepository|MockObject */
    private $indexRepository;
    private IndexDirective $subject;

    protected function setUp(): void
    {
        $this->parser          = $this->createMock(Parser::class);
        $this->indexRepository = $this->createMock(IndexRepository::class);
        $this->subject         = new IndexDirective($this->indexRepository);
    }

    public function testIndexDirectiveReturnsNull(): void
    {
        $node = $this->subject->processNode(
            $this->parser,
            '',
            'Main Index, Sub Index',
            []
        );
        self::assertNull($node);
    }

    public function testIndexDirectiveProcessingAddsLinkToRepository(): void
    {
        $this->indexRepository->expects(self::once())
            ->method('addTextAsIndex')
            ->with('Main Index; Sub Index', 'example.html');
        $this->subject->processNode(
            $this->parser,
            '',
            'Main Index; Sub Index',
            []
        );
    }
}
