<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2021;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2021\Day1;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2021
 */
class Day1Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day1::class;

    public function testDay1(): void
    {
        $assignment = new Day1();
        $assignment->setInput("199\n200\n208\n210\n200\n207\n240\n269\n260\n263\n");
        $output = $assignment->run();

        self::assertEquals(7, $output[0]);
        self::assertEquals(5, $output[1]);
    }
}
