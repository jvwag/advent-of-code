<?php

namespace jvwag\AdventOfCode\Tests\Year2015;

use jvwag\AdventOfCode\Year2015\Day4;
use PHPUnit\Framework\TestCase;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2015
 */
class Day4Test extends TestCase
{
    public function testDay4Part1Example1()
    {
        self::markTestSkipped("Skipping long test");

        $assignment = new Day4();
        $assignment->setInput("abcdef");
        $output = $assignment->run();

        self::assertEquals(609043, $output[0]);
    }

    public function testDay4Part1Example2()
    {
        self::markTestSkipped("Skipping long test");

        $assignment = new Day4();
        $assignment->setInput("pqrstuv");
        $output = $assignment->run();

        self::assertEquals(1048970, $output[0]);
    }
}
