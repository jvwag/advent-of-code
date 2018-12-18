<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2018;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2018\Day18;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2018
 */
class Day18Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day18::class;

    public function testDay18(): void
    {
        $assignment = new Day18();
        $assignment->setInput(
            ".#.#...|#.\n" .
            ".....#|##|\n" .
            ".|..|...#.\n" .
            "..|#.....#\n" .
            "#.#|||#|#|\n" .
            "...#.||...\n" .
            ".|....|...\n" .
            "||...#|.#|\n" .
            "|.||||..|.\n" .
            "...#.|..|.\n");
        $output = $assignment->run();

        self::assertSame(1147, $output[0]);
        self::assertSame(0, $output[1]);
    }
}
