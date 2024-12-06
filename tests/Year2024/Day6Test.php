<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2024;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2024\Day6;

class Day6Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day6::class;

    public function testDay6(): void
    {
        $assignment = new Day6();
        $assignment->setInput(
            "....#.....\n" .
            ".........#\n" .
            "..........\n" .
            "..#.......\n" .
            ".......#..\n" .
            "..........\n" .
            ".#..^.....\n" .
            "........#.\n" .
            "#.........\n" .
            "......#...\n");
        $output = $assignment->run();

        self::assertEquals(41, $output[0]);
        self::assertEquals(6, $output[1]);
    }
}
