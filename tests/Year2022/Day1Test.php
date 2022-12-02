<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2022;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2022\Day1;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2022
 */
class Day1Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day1::class;

    public function testDayTemplate(): void
    {
        $assignment = new Day1();
        $assignment->setInput("1000\n2000\n3000\n\n4000\n\n5000\n6000\n\n7000\n8000\n9000\n\n10000\n");
        $output = $assignment->run();

        self::assertEquals(24000, $output[0]);
        self::assertEquals(45000, $output[1]);
    }
}
