<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2025;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2025\Day6;

class Day6Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day6::class;

    public function testDay6(): void
    {
        $assignment = new Day6();
        $assignment->setInput("123 328  51 64 \n 45 64  387 23 \n  6 98  215 314\n*   +   *   +  \n");
        $output = $assignment->run();

        self::assertEquals(4277556, $output[0]);
        self::assertEquals(3263827, $output[1]);
    }
}
