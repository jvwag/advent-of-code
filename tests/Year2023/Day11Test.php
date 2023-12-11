<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2023;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2023\Day11;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2023
 */
class Day11Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day11::class;

    public function testDay11(): void
    {
        $assignment = new Day11();
        $assignment->setInput(
            "...#......\n" .
            ".......#..\n" .
            "#.........\n" .
            "..........\n" .
            "......#...\n" .
            ".#........\n" .
            ".........#\n" .
            "..........\n" .
            ".......#..\n" .
            "#...#.....\n");

        $output = $assignment->run();
        self::assertEquals(374, $output[0]);

        $output = $assignment->run(9);
        self::assertEquals(1030, $output[1]);

        $output = $assignment->run(99);
        self::assertEquals(8410, $output[1]);
    }
}
