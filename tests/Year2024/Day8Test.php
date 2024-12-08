<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2024;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2024\Day8;

class Day8Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day8::class;

    public function testDay8(): void
    {
        $assignment = new Day8();
        $assignment->setInput("............\n" .
            "........0...\n" .
            ".....0......\n" .
            ".......0....\n" .
            "....0.......\n" .
            "......A.....\n" .
            "............\n" .
            "............\n" .
            "........A...\n" .
            ".........A..\n" .
            "............\n" .
            "............\n");
        $output = $assignment->run();

        self::assertEquals(14, $output[0]);
        self::assertEquals(34, $output[1]);
    }
}
