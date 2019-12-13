<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2019;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2019\Day12;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2019
 */
class Day12Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day12::class;

    public function testDayPart1Example1(): void
    {
        $assignment = new Day12();
        $output = $assignment->run1($assignment->parseInput("<x=-1, y=0, z=2>\n<x=2, y=-10, z=-7>\n<x=4, y=-8, z=8>\n<x=3, y=5, z=-1>\n"), 10);
        self::assertEquals(179, $output);
    }

    public function testDayPart1Example2(): void
    {
        $assignment = new Day12();
        $output = $assignment->run1($assignment->parseInput("<x=-8, y=-10, z=0>\n<x=5, y=5, z=10>\n<x=2, y=-7, z=3>\n<x=9, y=-8, z=-3>\n"), 100);
        self::assertEquals(1940, $output);
    }


    public function testDayPart2Example1(): void
    {
        $assignment = new Day12();
        $output = $assignment->run2($assignment->parseInput("<x=-1, y=0, z=2>\n<x=2, y=-10, z=-7>\n<x=4, y=-8, z=8>\n<x=3, y=5, z=-1>\n"));
        self::assertEquals(2772, $output);
    }

    public function testDayPart2Example2(): void
    {
        $assignment = new Day12();
        $output = $assignment->run2($assignment->parseInput("<x=-8, y=-10, z=0>\n<x=5, y=5, z=10>\n<x=2, y=-7, z=3>\n<x=9, y=-8, z=-3>\n"));
        self::assertEquals(4686774924, $output);
    }
}
