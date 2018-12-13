<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2018;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2018\Day13;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2018
 */
class Day13Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day13::class;

    public function testDay13Part1(): void
    {
        $assignment = new Day13();
        $assignment->setInput("" .
            "/->-\\        " . "\n" .
            "|   |  /----\\" . "\n" .
            "| /-+--+-\\  |" . "\n" .
            "| | |  | v  |" . "\n" .
            "\\-+-/  \\-+--/" . "\n" .
            "  \\------/   " . "\n");
        $output = $assignment->run();

        self::assertEquals("7,3", $output[0]);
    }

    public function testDay13Part2(): void
    {
        $assignment = new Day13();
        $assignment->setInput("" .
            "/>-<\\  \n" .
            "|   |  \n" .
            "| /<+-\\\n" .
            "| | | v\n" .
            "\\>+</ |\n" .
            "  |   ^\n" .
            "  \\<->/\n");
        $output = $assignment->run();

        self::assertEquals("6,4", $output[1]);
    }
}
