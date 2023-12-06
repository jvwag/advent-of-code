<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2023;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2023\Day6;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2023
 */
class Day6Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day6::class;

    public function testDayTemplate(): void
    {
        $assignment = new Day6();
        $assignment->setInput("Time:      7  15   30\nDistance:  9  40  200\n");
        $output = $assignment->run();

        self::assertEquals(288, $output[0]);
        self::assertEquals(71503, $output[1]);
    }
}
