<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2024;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2024\Day4;

class Day4Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day4::class;

    public function testDay4(): void
    {
        $assignment = new Day4();
        $assignment->setInput(
            "MMMSXXMASM\n" .
            "MSAMXMSMSA\n" .
            "AMXSXMAAMM\n" .
            "MSAMASMSMX\n" .
            "XMASAMXAMM\n" .
            "XXAMMXXAMA\n" .
            "SMSMSASXSS\n" .
            "SAXAMASAAA\n" .
            "MAMMMXMMMM\n" .
            "MXMXAXMASX\n"
        );
        $output = $assignment->run();

        self::assertEquals(18, $output[0]);
        self::assertEquals(9, $output[1]);
    }
}
