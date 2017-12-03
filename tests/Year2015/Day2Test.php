<?php

namespace jvwag\AdventOfCode\Tests\Year2015;

use jvwag\AdventOfCode\Year2015\Day2;
use PHPUnit\Framework\TestCase;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2015
 */
class Day2Test extends TestCase
{
    public function testDay2()
    {
        $assignment = new Day2();
        $assignment->setInput("2x3x4\n1x1x10\n");
        $output = $assignment->run();

        self::assertEquals(58 + 43, $output[0]);
        self::assertEquals(34 + 14, $output[1]);
    }
}
