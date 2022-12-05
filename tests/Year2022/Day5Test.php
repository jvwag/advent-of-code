<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2022;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2022\Day5;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2022
 */
class Day5Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day5::class;

    public function testDay5(): void
    {
        $assignment = new Day5();
        $assignment->setInput(
            "    [D]    \n" .
            "[N] [C]    \n" .
            "[Z] [M] [P]\n" .
            " 1   2   3 \n" .
            "\n" .
            "move 1 from 2 to 1\n" .
            "move 3 from 1 to 3\n" .
            "move 2 from 2 to 1\n" .
            "move 1 from 1 to 2\n"
        );
        $output = $assignment->run();

        self::assertEquals("CMZ", $output[0]);
        self::assertEquals("MCD", $output[1]);
    }
}
