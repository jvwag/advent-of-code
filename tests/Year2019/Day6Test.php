<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2019;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2019\Day6;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2019
 */
class Day6Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day6::class;

    public function testDay6Part1Example(): void
    {
        $assignment = new Day6();
        $input = $assignment->parseInput("COM)B\nB)C\nC)D\nD)E\nE)F\nB)G\nG)H\nD)I\nE)J\nJ)K\nK)L");
        $output = $assignment->run1($input);

        self::assertSame(42, $output);
    }

    public function testDay6Part2Example(): void
    {
        $assignment = new Day6();
        $input = $assignment->parseInput("COM)B\nB)C\nC)D\nD)E\nE)F\nB)G\nG)H\nD)I\nE)J\nJ)K\nK)L\nK)YOU\nI)SAN");
        $output = $assignment->run2($input);

        self::assertSame(4, $output);
    }
}
