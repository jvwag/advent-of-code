<?php

namespace jvwag\AdventOfCode\Tests\Year2015;

use jvwag\AdventOfCode\Year2015\Day7;
use PHPUnit\Framework\TestCase;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2015
 */
class Day7Test extends TestCase
{
    public function testDayX()
    {
        $assignment = new Day7();
        $assignment->setInput(
            "123 -> a\n" .
            "456 -> y\n" .
            "a AND y -> d\n" .
            "a OR y -> e\n" .
            "a LSHIFT 2 -> f\n" .
            "y RSHIFT 2 -> g\n" .
            "NOT a -> h\n" .
            "NOT y -> i\n"
        );
        $output = $assignment->run();

        self::assertEquals(123, $output[0]);
    }
}
