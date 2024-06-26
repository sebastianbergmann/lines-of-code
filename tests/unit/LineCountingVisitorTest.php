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
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(LineCountingVisitor::class)]
#[UsesClass(LinesOfCode::class)]
#[Small]
final class LineCountingVisitorTest extends TestCase
{
    /**
     * @return non-empty-list<array{0: non-empty-string, 1: positive-int, 2: int, 3: int, 4: int}>
     */
    public static function provideData(): array
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

    /**
     * @param non-empty-string $sourceFile
     * @param positive-int     $linesOfCode
     * @param non-negative-int $commentLinesOfCode
     * @param non-negative-int $nonCommentLinesOfCode
     * @param non-negative-int $logicalLinesOfCode
     */
    #[DataProvider('provideData')]
    public function testCountsLinesOfCodeInAbstractSyntaxTree(string $sourceFile, int $linesOfCode, int $commentLinesOfCode, int $nonCommentLinesOfCode, int $logicalLinesOfCode): void
    {
        $source = file_get_contents($sourceFile);

        assert($source !== false);

        $nodes = (new ParserFactory)->createForHostVersion()->parse($source);

        assert($nodes !== null);

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
}
