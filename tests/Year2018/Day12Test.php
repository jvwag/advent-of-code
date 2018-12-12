<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2018;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2018\Day12;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2018
 */
class Day12Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day12::class;

    public function testDay12(): void
    {
        $assignment = new Day12();
        $assignment->setInput(
            "initial state: #..#.#..##......###...###\n\n" .
            "...## => #\n" .
            "..#.. => #\n" .
            ".#... => #\n" .
            ".#.#. => #\n" .
            ".#.## => #\n" .
            ".##.. => #\n" .
            ".#### => #\n" .
            "#.#.# => #\n" .
            "#.### => #\n" .
            "##.#. => #\n" .
            "##.## => #\n" .
            "###.. => #\n" .
            "###.# => #\n" .
            "####. => #\n"
        );
        $output = $assignment->run();

        self::assertEquals(325, $output[0]);
        self::assertEquals(50000000501, $output[1]);
    }
}
