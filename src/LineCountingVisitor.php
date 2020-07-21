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

use function array_unique;
use function count;
use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

final class LineCountingVisitor extends NodeVisitorAbstract
{
    /**
     * @var int
     */
    private $linesOfCode;

    /**
     * @var int
     */
    private $commentLinesOfCode = 0;

    /**
     * @var int[]
     */
    private $linesWithStatements = [];

    public function __construct(int $linesOfCode)
    {
        $this->linesOfCode = $linesOfCode;
    }

    public function enterNode(Node $node): void
    {
        foreach ($node->getComments() as $comment) {
            $this->commentLinesOfCode += ($comment->getEndLine() - $comment->getStartLine() + 1);
        }

        $this->linesWithStatements[] = $node->getStartLine();
    }

    public function result(): LinesOfCode
    {
        return new LinesOfCode(
            $this->linesOfCode,
            $this->commentLinesOfCode,
            $this->linesOfCode - $this->commentLinesOfCode,
            count(array_unique($this->linesWithStatements))
        );
    }
}
