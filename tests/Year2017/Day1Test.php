<?php

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Year2017\Day1;
use PHPUnit\Framework\TestCase;

/**
 * Class Day1Test
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */

/**
 * Class Day1Test
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day1Test extends TestCase
{
    public function testDay1Part1Example1()
    {
        $assignment = new Day1();
        $assignment->setInput("1122");
        $output = $assignment->run();

        self::assertSame(3, $output[0]);
    }

    public function testDay1Part1Example2()
    {
        $assignment = new Day1();
        $assignment->setInput("1111");
        $output = $assignment->run();

        static::assertSame(4, $output[0]);
    }

    public function testDay1Part1Example3()
    {
        $assignment = new Day1();
        $assignment->setInput("1234");
        $output = $assignment->run();

        static::assertSame(0, $output[0]);
    }

    public function testDay1Part1Example4()
    {
        $assignment = new Day1();
        $assignment->setInput("91212129");
        $output = $assignment->run();

        static::assertSame(9, $output[0]);
    }

    public function testDay1Part2Example1()
    {
        $assignment = new Day1();
        $assignment->setInput("1212");
        $output = $assignment->run();

        static::assertSame(6, $output[1]);
    }

    public function testDay1Part2Example2()
    {
        $assignment = new Day1();
        $assignment->setInput("1221");
        $output = $assignment->run();

        static::assertSame(0, $output[1]);
    }

    public function testDay1Part2Example3()
    {
        $assignment = new Day1();
        $assignment->setInput("123425");
        $output = $assignment->run();

        static::assertSame(4, $output[1]);
    }

    public function testDay1Part2Example4()
    {
        $assignment = new Day1();
        $assignment->setInput("123123");
        $output = $assignment->run();

        static::assertSame(12, $output[1]);
    }

    public function testDay1Part2Example5()
    {
        $assignment = new Day1();
        $assignment->setInput("12131415");
        $output = $assignment->run();

        static::assertSame(4, $output[1]);
    }
}
