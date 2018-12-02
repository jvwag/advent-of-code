<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2016;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2016\Day3;

/**
 * Class Day3Test
 *
 * @package jvwag\AdventOfCode\Tests\Year2016
 */
class Day3Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day3::class;

    public function testDay3Part1Example1(): void
    {
        $assignment = new Day3();
        $assignment->setInput("5 10 25");
        $output = $assignment->run();

        static::assertEquals(0, $output[0]);
    }

    public function testDay3Part1Test1(): void
    {
        $assignment = new Day3();
        $assignment->setInput("4 3 3");
        $output = $assignment->run();

        static::assertEquals(1, $output[0]);
    }

    public function testDay3Part1Test2(): void
    {
        $assignment = new Day3();
        $assignment->setInput("3 4 3");
        $output = $assignment->run();

        static::assertEquals(1, $output[0]);
    }

    public function testDay3Part1Test3(): void
    {
        $assignment = new Day3();
        $assignment->setInput("3 3 4");
        $output = $assignment->run();

        static::assertEquals(1, $output[0]);
    }

    public function testDay3Part2Test1(): void
    {
        $assignment = new Day3();
        $assignment->setInput("1 2 3\n4 5 6\n7 8 9\n");
        $output = $assignment->run();

        static::assertEquals(0, $output[1]);
    }

    public function testDay3Part2Test2(): void
    {
        $assignment = new Day3();
        $assignment->setInput("1 4 7\n2 5 7\n3 6 9\n");
        $output = $assignment->run();

        static::assertEquals(2, $output[1]);
    }

}
