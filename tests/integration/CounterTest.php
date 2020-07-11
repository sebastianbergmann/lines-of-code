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
 * @covers \SebastianBergmann\LinesOfCode\CommentLinesOfCodeVisitor
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

        $this->assertSame(51, $count->loc());
        $this->assertSame(13, $count->cloc());
        $this->assertSame(38, $count->ncloc());
    }

    public function testCountsLinesOfCodeInSourceString(): void
    {
        $count = (new Counter)->countInSourceString(file_get_contents(__DIR__ . '/../_fixture/ExampleClass.php'));

        $this->assertSame(51, $count->loc());
        $this->assertSame(13, $count->cloc());
        $this->assertSame(38, $count->ncloc());
    }

    public function testCountsLinesOfCodeInAbstractSyntaxTree(): void
    {
        $nodes = (new ParserFactory)->create(ParserFactory::PREFER_PHP7)->parse(file_get_contents(__DIR__ . '/../_fixture/ExampleClass.php'));

        assert($nodes !== null);

        $count = (new Counter)->countInAbstractSyntaxTree(51, $nodes);

        $this->assertSame(51, $count->loc());
        $this->assertSame(13, $count->cloc());
        $this->assertSame(38, $count->ncloc());
    }
}
