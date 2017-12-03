<?php

namespace jvwag\AdventOfCode\Tests\Year2015;

use jvwag\AdventOfCode\Year2015\Day17;
use PHPUnit\Framework\TestCase;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2015
 */
class Day17Test extends TestCase
{
    public function testDay17()
    {
        $assignment = new Day17();
        $assignment->setInput("20\n15\n10\n5\n5\n");
        $output = $assignment->calculate(25);

        self::assertEquals(4, $output[0]);
        self::assertEquals(3, $output[1]);
    }
}
