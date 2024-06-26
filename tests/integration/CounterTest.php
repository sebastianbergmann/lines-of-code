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

use function assert;
use function file_get_contents;
use PhpParser\ParserFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Medium;
use PHPUnit\Framework\TestCase;

#[CoversClass(Counter::class)]
#[CoversClass(LineCountingVisitor::class)]
#[Medium]
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
        $source = file_get_contents(__DIR__ . '/../_fixture/ExampleClass.php');

        assert($source !== false);

        $count = (new Counter)->countInSourceString($source);

        $this->assertSame(43, $count->linesOfCode());
        $this->assertSame(5, $count->commentLinesOfCode());
        $this->assertSame(38, $count->nonCommentLinesOfCode());
        $this->assertSame(13, $count->logicalLinesOfCode());
    }

    public function testCountsLinesOfCodeInAbstractSyntaxTree(): void
    {
        $source = file_get_contents(__DIR__ . '/../_fixture/ExampleClass.php');

        assert($source !== false);

        $nodes = (new ParserFactory)->createForHostVersion()->parse($source);

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
