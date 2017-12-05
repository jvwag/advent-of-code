<?php

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Year2017\Day5;
use PHPUnit\Framework\TestCase;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day5Test extends TestCase
{
    public function testDay5Example()
    {
        $assignment = new Day5();
        $assignment->setInput("0\n3\n0\n1\n-3\n");
        $output = $assignment->run();

        self::assertEquals(5, $output[0]);
        self::assertEquals(10, $output[1]);
    }

}
