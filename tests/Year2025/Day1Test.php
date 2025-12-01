<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2025;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2025\Day1;

class Day1Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day1::class;

    public function testDay1(): void
    {
        $assignment = new Day1();
        $assignment->setInput("L68\nL30\nR48\nL5\nR60\nL55\nL1\nL99\nR14\nL82\n");
        $output = $assignment->run();

        self::assertEquals(3, $output[0]);
        self::assertEquals(6, $output[1]);
    }

    public function testDay1b(): void
    {
        $assignment = new Day1();
        $assignment->setInput("L68\nL30\nR48\nL5\nR60\nL555\nL1\nL99\nR514\nL82\n");
        $output = $assignment->run();

        self::assertEquals(3, $output[0]);
        self::assertEquals(16, $output[1]);
    }
}
