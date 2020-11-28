<?php declare(strict_types=1);
namespace SebastianBergmann\Complexity\TestFixture;

final class ExampleClass
{
    public function method(): void
    {
        if (true || false) {
            if (true && false) {
                for ($i = 0; $i <= 1; $i++) {
                    $a = true ? 'foo' : 'bar';
                }

                foreach (range(0, 1) as $i) {
                    switch ($i) {
                        case 0:
                            break;

                        case 1:
                            break;

                        default:
                    }
                }
            }
        } elseif (null) {
            try {
                // ...
            } catch (Throwable $t) {
                /* ... */
            }
        }

        /*
         * ...
         */
        while (true) {
        }

        do {
        } while (false);
    }
}
