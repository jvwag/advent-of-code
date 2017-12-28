<?php

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Year2017\Day17;
use PHPUnit\Framework\TestCase;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day17Test extends TestCase
{
    public function testDay17()
    {
        $assignment = new Day17();
        $assignment->setInput("3");
        $output = $assignment->run();

        self::assertEquals(638, $output[0]);
        self::assertEquals(1222153, $output[1]);
    }
}
