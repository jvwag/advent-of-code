<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2023;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2023\Day2;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2023
 */
class Day2Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day2::class;

    public function testDayTemplate(): void
    {
        $assignment = new Day2();
        $assignment->setInput(
            "Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green\n" .
            "Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue\n" .
            "Game 3: 8 green, 6 blue, 20 red; 5 blue, 4 red, 13 green; 5 green, 1 red\n" .
            "Game 4: 1 green, 3 red, 6 blue; 3 green, 6 red; 3 green, 15 blue, 14 red\n" .
            "Game 5: 6 red, 1 blue, 3 green; 2 blue, 1 red, 2 green\n"
        );
        $output = $assignment->run();

        self::assertEquals(8, $output[0]);
        self::assertEquals(2286, $output[1]);
    }
}
