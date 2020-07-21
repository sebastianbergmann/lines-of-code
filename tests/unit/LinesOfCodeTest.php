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

use PHPUnit\Framework\TestCase;

/**
 * @covers \SebastianBergmann\LinesOfCode\LinesOfCode
 *
 * @small
 */
final class LinesOfCodeTest extends TestCase
{
    /**
     * @testdox Has Lines of Code (LOC)
     */
    public function testHasLinesOfCode(): void
    {
        $this->assertSame(1, $this->linesOfCode()->linesOfCode());
    }

    /**
     * @testdox Has Comment Lines of Code (CLOC)
     */
    public function testHasCommentLinesOfCode(): void
    {
        $this->assertSame(1, $this->linesOfCode()->commentLinesOfCode());
    }

    /**
     * @testdox Has Non-Comment Lines of Code (NCLOC)
     */
    public function testHasNonCommentLinesOfCode(): void
    {
        $this->assertSame(0, $this->linesOfCode()->nonCommentLinesOfCode());
    }

    /**
     * @testdox Has Logical Lines of Code (LLOC)
     */
    public function testHasLogicalLinesOfCode(): void
    {
        $this->assertSame(0, $this->linesOfCode()->logicalLinesOfCode());
    }

    public function testLinesOfCodeCannotBeNegative(): void
    {
        $this->expectException(NegativeValueException::class);
        $this->expectExceptionMessage('$linesOfCode must not be negative');

        new LinesOfCode(-1, 0, 0, 0);
    }

    public function testCommentLinesOfCodeCannotBeNegative(): void
    {
        $this->expectException(NegativeValueException::class);
        $this->expectExceptionMessage('$commentLinesOfCode must not be negative');

        new LinesOfCode(0, -1, 0, 0);
    }

    public function testNonCommentLinesOfCodeCannotBeNegative(): void
    {
        $this->expectException(NegativeValueException::class);
        $this->expectExceptionMessage('$nonCommentLinesOfCode must not be negative');

        new LinesOfCode(0, 0, -1, 0);
    }

    public function testLogicalLinesOfCodeCannotBeNegative(): void
    {
        $this->expectException(NegativeValueException::class);
        $this->expectExceptionMessage('$logicalLinesOfCode must not be negative');

        new LinesOfCode(0, 0, 0, -1);
    }

    /**
     * @testdox Lines of Code = Comment Lines of Code + Non-Comment Lines of Code
     */
    public function testNumbersHaveToMakeSense(): void
    {
        $this->expectException(IllogicalValuesException::class);
        $this->expectExceptionMessage('$linesOfCode !== $commentLinesOfCode + $nonCommentLinesOfCode');

        new LinesOfCode(1, 2, 2, 0);
    }

    public function testTwoInstancesCanBeAdded(): void
    {
        $a = new LinesOfCode(2, 1, 1, 1);
        $b = new LinesOfCode(4, 2, 2, 2);

        $sum = $a->plus($b);

        $this->assertSame(6, $sum->linesOfCode());
        $this->assertSame(3, $sum->commentLinesOfCode());
        $this->assertSame(3, $sum->nonCommentLinesOfCode());
        $this->assertSame(3, $sum->logicalLinesOfCode());
    }

    private function linesOfCode(): LinesOfCode
    {
        return new LinesOfCode(1, 1, 0, 0);
    }
}
