<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2025;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2025\Day5;

class Day5Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day5::class;

    public function testDay5(): void
    {
        $assignment = new Day5();
        $assignment->setInput("3-5\n10-14\n16-20\n12-18\n\n1\n5\n8\n11\n17\n32\n");
        $output = $assignment->run();

        self::assertEquals(3, $output[0]);
        self::assertEquals(14, $output[1]);
    }
}
