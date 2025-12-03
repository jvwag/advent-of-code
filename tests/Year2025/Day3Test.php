<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2025;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2025\Day3;

class Day3Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day3::class;

    public function testDay3(): void
    {
        $assignment = new Day3();
        $assignment->setInput("987654321111111\n811111111111119\n234234234234278\n818181911112111\n");
        $output = $assignment->run();

        self::assertEquals(357, $output[0]);
        self::assertEquals(3121910778619, $output[1]);
    }
}
