<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2024;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2024\Day3;

class Day3Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day3::class;

    public function testDayTemplate(): void
    {
        $assignment = new Day3();
        // example from part1
        $assignment->setInput("xmul(2,4)%&mul[3,7]!@^do_not_mul(5,5)+mul(32,64]then(mul(11,8)mul(8,5))\n");
        $output = $assignment->run();
        self::assertEquals(161, $output[0]);

        // example from part2
        $assignment->setInput("xmul(2,4)&mul[3,7]!^don't()_mul(5,5)+mul(32,64](mul(11,8)undo()?mul(8,5))\n");
        $output = $assignment->run();
        self::assertEquals(48, $output[1]);

        // extra test for case "don't()" without a "do()" at the end of the line
        $assignment->setInput("xmul(2,4)&mul[3,7]!^don't()_mul(5,5)+mul(32,64](mul(11,8)undo()?mul(8,5))don't()0mul(1,20)\n");
        $output = $assignment->run();
        self::assertEquals(48, $output[1]);
    }
}
