<?php

namespace jvwag\AdventOfCode\Tests\Year2015;

use jvwag\AdventOfCode\Year2015\Day6;
use PHPUnit\Framework\TestCase;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2015
 */
class Day6Test extends TestCase
{
    public function testDay6Part1Example1()
    {
        $assignment = new Day6();
        $assignment->setInput("turn on 0,0 through 999,999");
        $output = $assignment->run();

        self::assertEquals(1000 * 1000, $output[0]);
    }

    public function testDay6Part1Example2()
    {
        $assignment = new Day6();
        $assignment->setInput("turn on 0,0 through 999,0");
        $output = $assignment->run();

        self::assertEquals(1000, $output[0]);
    }

    public function testDay6Part1Example3()
    {
        $assignment = new Day6();
        $assignment->setInput("turn on 0,0 through 999,999\nturn off 499,499 through 500,500");
        $output = $assignment->run();

        self::assertEquals(1000 * 1000 - 4, $output[0]);
    }

    public function testDay6Part2Example1()
    {
        $assignment = new Day6();
        $assignment->setInput("turn on 0,0 through 0,0");
        $output = $assignment->run();

        self::assertEquals(1, $output[1]);
    }

    public function testDay6Part2Example1b()
    {
        $assignment = new Day6();
        $assignment->setInput("turn on 0,0 through 0,0\nturn on 0,0 through 0,0\n");
        $output = $assignment->run();

        self::assertEquals(2, $output[1]);
    }

    public function testDay6Part2Example2()
    {
        $assignment = new Day6();
        $assignment->setInput("toggle 0,0 through 999,999");
        $output = $assignment->run();

        self::assertEquals(2000000, $output[1]);
    }
}
