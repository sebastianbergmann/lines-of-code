<?php declare(strict_types=1);
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
