<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2025;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2025\Day7;

class Day7Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day7::class;

    public function testDay7(): void
    {
        $assignment = new Day7();
        $assignment->setInput(
            ".......S.......\n" .
            "...............\n" .
            ".......^.......\n" .
            "...............\n" .
            "......^.^......\n" .
            "...............\n" .
            ".....^.^.^.....\n" .
            "...............\n" .
            "....^.^...^....\n" .
            "...............\n" .
            "...^.^...^.^...\n" .
            "...............\n" .
            "..^...^.....^..\n" .
            "...............\n" .
            ".^.^.^.^.^...^.\n" .
            "...............\n"
        );
        $output = $assignment->run();

        self::assertEquals(21, $output[0]);
        self::assertEquals(40, $output[1]);
    }
}
