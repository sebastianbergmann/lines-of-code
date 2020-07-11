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
        $this->assertSame(1, $this->linesOfCode()->loc());
    }

    /**
     * @testdox Has Comment Lines of Code (CLOC)
     */
    public function testHasCommentLinesOfCode(): void
    {
        $this->assertSame(1, $this->linesOfCode()->cloc());
    }

    /**
     * @testdox Has Non-Comment Lines of Code (NCLOC)
     */
    public function testHasNonCommentLinesOfCode(): void
    {
        $this->assertSame(0, $this->linesOfCode()->ncloc());
    }

    public function testLinesOfCodeCannotBeNegative(): void
    {
        $this->expectException(NegativeValueException::class);
        $this->expectExceptionMessage('$loc must not be negative');

        new LinesOfCode(-1, 0, 0);
    }

    public function testCommentLinesOfCodeCannotBeNegative(): void
    {
        $this->expectException(NegativeValueException::class);
        $this->expectExceptionMessage('$cloc must not be negative');

        new LinesOfCode(0, -1, 0);
    }

    public function testNonCommentLinesOfCodeCannotBeNegative(): void
    {
        $this->expectException(NegativeValueException::class);
        $this->expectExceptionMessage('$ncloc must not be negative');

        new LinesOfCode(0, 0, -1);
    }

    /**
     * @testdox Lines of Code = Comment Lines of Code + Non-Comment Lines of Code
     */
    public function testNumbersHaveToMakeSense(): void
    {
        $this->expectException(IllogicalValuesException::class);
        $this->expectExceptionMessage('$loc !== $cloc + $ncloc');

        new LinesOfCode(1, 2, 2);
    }

    private function linesOfCode(): LinesOfCode
    {
        return new LinesOfCode(1, 1, 0);
    }
}
