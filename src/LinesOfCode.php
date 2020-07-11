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

/**
 * @psalm-immutable
 */
final class LinesOfCode
{
    /**
     * @var int
     */
    private $loc;

    /**
     * @var int
     */
    private $cloc;

    /**
     * @var int
     */
    private $ncloc;

    public function __construct(int $loc, int $cloc, int $ncloc)
    {
        $this->loc   = $loc;
        $this->cloc  = $cloc;
        $this->ncloc = $ncloc;
    }

    public function loc(): int
    {
        return $this->loc;
    }

    public function cloc(): int
    {
        return $this->cloc;
    }

    public function ncloc(): int
    {
        return $this->ncloc;
    }
}
