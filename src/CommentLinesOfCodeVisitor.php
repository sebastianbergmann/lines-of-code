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

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

final class CommentLinesOfCodeVisitor extends NodeVisitorAbstract
{
    /**
     * @var int
     */
    private $cloc = 0;

    public function enterNode(Node $node): void
    {
        foreach ($node->getComments() as $comment) {
            $this->cloc += ($comment->getEndLine() - $comment->getStartLine() + 1);
        }
    }

    public function cloc(): int
    {
        return $this->cloc;
    }
}
