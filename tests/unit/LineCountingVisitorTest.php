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
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \SebastianBergmann\LinesOfCode\LineCountingVisitor
 *
 * @uses \SebastianBergmann\LinesOfCode\LinesOfCode
 *
 * @small
 */
final class LineCountingVisitorTest extends TestCase
{
    /**
     * @dataProvider provideData
     */
    public function testCountsLinesOfCodeInAbstractSyntaxTree(string $sourceFile, int $linesOfCode, int $commentLinesOfCode, int $nonCommentLinesOfCode, int $logicalLinesOfCode): void
    {
        $nodes = (new ParserFactory)->createForHostVersion()->parse(
            file_get_contents($sourceFile)
        );

        $traverser = new NodeTraverser;

        $visitor = new LineCountingVisitor($linesOfCode);

        $traverser->addVisitor($visitor);

        /* @noinspection UnusedFunctionResultInspection */
        $traverser->traverse($nodes);

        $this->assertSame($linesOfCode, $visitor->result()->linesOfCode());
        $this->assertSame($commentLinesOfCode, $visitor->result()->commentLinesOfCode());
        $this->assertSame($nonCommentLinesOfCode, $visitor->result()->nonCommentLinesOfCode());
        $this->assertSame($logicalLinesOfCode, $visitor->result()->logicalLinesOfCode());
    }

    public function provideData(): array
    {
        return [
            [
                __DIR__ . '/../_fixture/ExampleClass.php',
                51,
                5,
                46,
                13,
            ],
            [
                __DIR__ . '/../_fixture/source_with_ignore.php',
                44,
                9,
                35,
                4,
            ],
            [
                __DIR__ . '/../_fixture/source_without_newline.php',
                1,
                1,
                0,
                0,
            ],
        ];
    }
}
