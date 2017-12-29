<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2017\Day2;

/**
 * Class Day1Test
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */

/**
 * Class Day2Test
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day2Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day2::class;

    public function testDay1Part1Example1()
    {
        $assignment = new Day2();
        $assignment->setInput("5 1 9 5\n7 5 3\n2 4 6 8\n");
        $output = $assignment->run();

        self::assertSame(18, $output[0]);
    }

    public function testDay2Part2Example1()
    {
        $assignment = new Day2();
        $assignment->setInput("5 9 2 8\n9 4 7 3\n3 8 6 5\n");
        $output = $assignment->run();

        self::assertSame(18, $output[0]);
        self::assertSame(9, $output[1]);

    }
}
