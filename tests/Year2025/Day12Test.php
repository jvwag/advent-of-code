<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2025;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2025\Day12;

class Day12Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day12::class;

    public function testDay12(): void
    {
        $assignment = new Day12();
        $assignment->setInput(
            "0:\n###\n##.\n##.\n\n" .
            "1:\n###\n##.\n.##\n\n" .
            "2:\n.##\n###\n##.\n\n" .
            "3:\n##.\n###\n##.\n\n" .
            "4:\n###\n#..\n###\n\n" .
            "5:\n###\n.#.\n###\n\n" .
            "4x4: 0 0 0 0 2 0\n" .
            "12x5: 1 0 1 0 2 2\n" .
            "12x5: 1 0 1 0 3 2\n"
        );
        $output = $assignment->run();

        self::assertEquals(2, $output[0]);
        self::assertEquals(null, $output[1]);
    }
}
