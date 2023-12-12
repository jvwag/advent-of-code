<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2023;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2023\Day12;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2023
 */
class Day12Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day12::class;

    public function testDay12(): void
    {
        $assignment = new Day12();
        $assignment->setInput(
            "???.### 1,1,3\n" .
            ".??..??...?##. 1,1,3\n" .
            "?#?#?#?#?#?#?#? 1,3,1,6\n" .
            "????.#...#... 4,1,1\n" .
            "????.######..#####. 1,6,5\n" .
            "?###???????? 3,2,1\n"
        );
        $output = $assignment->run();

        self::assertEquals(21, $output[0]);
        self::assertEquals(null, $output[1]);
    }
}
