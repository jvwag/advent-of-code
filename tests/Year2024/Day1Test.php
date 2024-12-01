<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2024;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2024\Day1;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2024
 */
class Day1Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day1::class;

    public function testDayTemplate(): void
    {
        $assignment = new Day1();
        $assignment->setInput("3   4\n4   3\n2   5\n1   3\n3   9\n3   3\n");
        $output = $assignment->run();

        self::assertEquals(11, $output[0]);
        self::assertEquals(31, $output[1]);
    }
}
