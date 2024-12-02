<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2024;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2024\Day2;

class Day2Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day2::class;

    public function testDayTemplate(): void
    {
        $assignment = new Day2();
        $assignment->setInput("7 6 4 2 1\n1 2 7 8 9\n9 7 6 2 1\n1 3 2 4 5\n8 6 4 4 1\n1 3 6 7 9\n");
        $output = $assignment->run();

        self::assertEquals(2, $output[0]);
        self::assertEquals(4, $output[1]);
    }
}
