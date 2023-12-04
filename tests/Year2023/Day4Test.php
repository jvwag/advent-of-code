<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2023;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2023\Day4;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2023
 */
class Day4Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day4::class;

    public function testDayTemplate(): void
    {
        $assignment = new Day4();
        $assignment->setInput(
            "Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53\n" .
            "Card 2: 13 32 20 16 61 | 61 30 68 82 17 32 24 19\n" .
            "Card 3:  1 21 53 59 44 | 69 82 63 72 16 21 14  1\n" .
            "Card 4: 41 92 73 84 69 | 59 84 76 51 58  5 54 83\n" .
            "Card 5: 87 83 26 28 32 | 88 30 70 12 93 22 82 36\n" .
            "Card 6: 31 18 13 56 72 | 74 77 10 23 35 67 36 11\n");
        $output = $assignment->run();

        self::assertEquals(13, $output[0]);
        self::assertEquals(30, $output[1]);
    }
}
