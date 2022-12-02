<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2022;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2022\Day2;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2022
 */
class Day2Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day2::class;

    public function testDay2(): void
    {
        $assignment = new Day2();
        $assignment->setInput("A Y\nB X\nC Z\n");
        $output = $assignment->run();

        self::assertEquals(15, $output[0]);
        self::assertEquals(12, $output[1]);
    }
}
