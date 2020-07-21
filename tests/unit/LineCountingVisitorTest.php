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
    public function testCountsLinesOfCodeInAbstractSyntaxTree(): void
    {
        $nodes = (new ParserFactory)->create(ParserFactory::PREFER_PHP7)->parse(
            file_get_contents(__DIR__ . '/../_fixture/ExampleClass.php')
        );

        $traverser = new NodeTraverser;

        $visitor = new LineCountingVisitor(51);

        $traverser->addVisitor($visitor);

        /* @noinspection UnusedFunctionResultInspection */
        $traverser->traverse($nodes);

        $this->assertSame(51, $visitor->result()->linesOfCode());
        $this->assertSame(13, $visitor->result()->commentLinesOfCode());
        $this->assertSame(38, $visitor->result()->nonCommentLinesOfCode());
        $this->assertSame(23, $visitor->result()->logicalLinesOfCode());
    }
}
