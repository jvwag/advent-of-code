<?php

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Year2017\Day13;
use PHPUnit\Framework\TestCase;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day13Test extends TestCase
{
    public function testDay13()
    {
        $assignment = new Day13();
        $assignment->setInput(
            "0: 3\n" .
            "1: 2\n" .
            "4: 4\n" .
            "6: 4\n"
        );
        $output = $assignment->run();

        self::assertEquals(24, $output[0]);
        self::assertEquals(10, $output[1]);
    }
}
