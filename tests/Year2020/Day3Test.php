<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2020;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2020\Day3;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2020
 */
class Day3Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day3::class;

    public function testDayTemplate(): void
    {
        $assignment = new Day3();
        $assignment->setInput(
            "..##.......\n" .
            "#...#...#..\n" .
            ".#....#..#.\n" .
            "..#.#...#.#\n" .
            ".#...##..#.\n" .
            "..#.##.....\n" .
            ".#.#.#....#\n" .
            ".#........#\n" .
            "#.##...#...\n" .
            "#...##....#\n" .
            ".#..#...#.#\n"
        );

        self::assertEquals(7, $assignment->run()[0]);
        self::assertEquals(336, $assignment->run()[1]);
    }
}
