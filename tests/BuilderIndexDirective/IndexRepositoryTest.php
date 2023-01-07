<?php

declare(strict_types=1);

namespace Doctrine\Tests\RST\BuilderIndexDirective;

use Doctrine\RST\Directives\IndexDirective;
use Doctrine\RST\ErrorManager;
use Doctrine\RST\Meta\Model\Index;
use Doctrine\RST\Meta\Repository\IndexRepository;
use Doctrine\RST\Parser;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class IndexRepositoryTest extends TestCase
{
    /** @var ErrorManager|MockObject */
    private $errorManager;

    protected function setUp(): void
    {
        $this->errorManager          = $this->createMock(ErrorManager::class);
    }

    public function testAddIndex() {
        $subject = new IndexRepository($this->errorManager);
        $index = new Index('Main', 'Sub', 'example.html');
        $subject->addIndex($index);
        self::assertArrayHasKey('Main', $subject->getIndexArray());
        self::assertIsArray($subject->getIndexArray()['Main']);
        self::assertArrayHasKey('Sub', $subject->getIndexArray()['Main']);
        self::assertContains($index, $subject->getIndexArray()['Main']['Sub']);
    }
    public function testAddTwoIndexWithSameKey() {
        $subject = new IndexRepository($this->errorManager);
        $index = new Index('Main', 'Sub', 'example.html');
        $index2 = new Index('Main', 'Sub', 'example2.html');
        $subject->addIndex($index);
        $subject->addIndex($index2);
        self::assertContains($index, $subject->getIndexArray()['Main']['Sub']);
        self::assertContains($index2, $subject->getIndexArray()['Main']['Sub']);
    }

    public function testAddTextAsIndex() {
        $subject = new IndexRepository($this->errorManager);
        $subject->addTextAsIndex('Main; Sub', 'example.html');
        self::assertArrayHasKey('Main', $subject->getIndexArray());
        self::assertIsArray($subject->getIndexArray()['Main']);
        self::assertArrayHasKey('Sub', $subject->getIndexArray()['Main']);
    }
}