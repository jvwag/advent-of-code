<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2016;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2016\Day1;

/**
 * Class Day1Test
 *
 * @package jvwag\AdventOfCode\Tests\Year2016
 */
class Day1Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day1::class;

    public function testDay1Part1Example1()
    {
        $assignment = new Day1();
        $assignment->setInput("R2, L3");
        $output = $assignment->run();

        self::assertSame(5, $output[0]);
    }

    public function testDay1Part1Example2()
    {
        $assignment = new Day1();
        $assignment->setInput("R2, R2, R2");
        $output = $assignment->run();

        static::assertSame(2, $output[0]);
    }

    public function testDay1Part1Example3()
    {
        $assignment = new Day1();
        $assignment->setInput("R5, L5, R5, R3");
        $output = $assignment->run();

        static::assertSame(12, $output[0]);
    }

    public function testDay1Part2Example1()
    {
        $assignment = new Day1();
        $assignment->setInput("R8, R4, R4, R8");
        $output = $assignment->run();

        static::assertSame(4, $output[1]);
    }
}
