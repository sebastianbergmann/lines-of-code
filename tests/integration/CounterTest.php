<?php declare(strict_types=1);
/*
 * This file is part of sebastian/lines-of-code.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianBergmann\LinesOfCode;

use function file_get_contents;
use PhpParser\ParserFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \SebastianBergmann\LinesOfCode\Counter
 * @covers \SebastianBergmann\LinesOfCode\LineCountingVisitor
 *
 * @uses \SebastianBergmann\LinesOfCode\LinesOfCode
 *
 * @medium
 */
final class CounterTest extends TestCase
{
    public function testCountsLinesOfCodeInSourceFile(): void
    {
        $count = (new Counter)->countInSourceFile(__DIR__ . '/../_fixture/ExampleClass.php');

        $this->assertSame(43, $count->linesOfCode());
        $this->assertSame(5, $count->commentLinesOfCode());
        $this->assertSame(38, $count->nonCommentLinesOfCode());
        $this->assertSame(13, $count->logicalLinesOfCode());
    }

    public function testCountsLinesOfCodeInSourceString(): void
    {
        $count = (new Counter)->countInSourceString(file_get_contents(__DIR__ . '/../_fixture/ExampleClass.php'));

        $this->assertSame(43, $count->linesOfCode());
        $this->assertSame(5, $count->commentLinesOfCode());
        $this->assertSame(38, $count->nonCommentLinesOfCode());
        $this->assertSame(13, $count->logicalLinesOfCode());
    }

    public function testCountsLinesOfCodeInAbstractSyntaxTree(): void
    {
        $nodes = (new ParserFactory)->createForHostVersion()->parse(
            file_get_contents(__DIR__ . '/../_fixture/ExampleClass.php')
        );

        assert($nodes !== null);

        $count = (new Counter)->countInAbstractSyntaxTree(51, $nodes);

        $this->assertSame(51, $count->linesOfCode());
        $this->assertSame(5, $count->commentLinesOfCode());
        $this->assertSame(46, $count->nonCommentLinesOfCode());
        $this->assertSame(13, $count->logicalLinesOfCode());
    }

    public function testHandlesFileWithoutNewline(): void
    {
        $count = (new Counter)->countInSourceFile(__DIR__ . '/../_fixture/source_without_newline.php');

        $this->assertSame(1, $count->linesOfCode());
        $this->assertSame(1, $count->commentLinesOfCode());
        $this->assertSame(0, $count->nonCommentLinesOfCode());
        $this->assertSame(0, $count->logicalLinesOfCode());
    }
}
