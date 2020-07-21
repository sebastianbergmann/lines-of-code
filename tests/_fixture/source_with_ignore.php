<?php declare(strict_types=1);
/*
 * This file is part of sebastian/lines-of-code.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
if ($neverHappens) {
    // @codeCoverageIgnoreStart
    print '*';
    // @codeCoverageIgnoreEnd
}

/**
 * @codeCoverageIgnore
 */
class Foo
{
    public function bar(): void
    {
    }
}

class Bar
{
    /**
     * @codeCoverageIgnore
     */
    public function foo(): void
    {
    }
}

function baz(): void
{
    print '*'; // @codeCoverageIgnore
}

interface Bor
{
    public function foo();
}
