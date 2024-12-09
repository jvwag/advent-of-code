<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2024;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2024\Day9;

class Day9Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day9::class;

    public function testDay9(): void
    {
        $assignment = new Day9();
        $assignment->setInput("2333133121414131402");
        $output = $assignment->run();

        self::assertEquals(1928, $output[0]);
        self::assertEquals(2858, $output[1]);
    }
}
