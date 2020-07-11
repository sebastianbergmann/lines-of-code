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
        $this->assertSame(2, $this->linesOfCode()->loc());
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
        $this->assertSame(1, $this->linesOfCode()->ncloc());
    }

    private function linesOfCode(): LinesOfCode
    {
        return new LinesOfCode(2, 1, 1);
    }
}
