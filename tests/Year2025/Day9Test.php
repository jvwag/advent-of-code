<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2025;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2025\Day9;

class Day9Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day9::class;

    public function testDay9(): void
    {
        $assignment = new Day9();
        $assignment->setInput("7,1\n11,1\n11,7\n9,7\n9,5\n2,5\n2,3\n7,3\n");
        $output = $assignment->run();

        self::assertEquals(50, $output[0]);
        self::assertEquals(null, $output[1]);
    }
}
