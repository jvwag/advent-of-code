<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2021;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2021\Day5;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2021
 */
class Day5Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day5::class;

    public function testDay5(): void
    {
        $assignment = new Day5();
        $assignment->setInput(
            "0,9 -> 5,9\n" .
            "8,0 -> 0,8\n" .
            "9,4 -> 3,4\n" .
            "2,2 -> 2,1\n" .
            "7,0 -> 7,4\n" .
            "6,4 -> 2,0\n" .
            "0,9 -> 2,9\n" .
            "3,4 -> 1,4\n" .
            "0,0 -> 8,8\n" .
            "5,5 -> 8,2\n"
        );
        $output = $assignment->run();

        self::assertEquals(5, $output[0]);
        self::assertEquals(12, $output[1]);
    }
}
