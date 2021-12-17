<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2021;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2021\Day17;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2021
 */
class Day17Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day17::class;

    public function testDay17(): void
    {
        $assignment = new Day17();
        $assignment->setInput("target area: x=20..30, y=-10..-5");
        $output = $assignment->run();

        self::assertEquals(45, $output[0]);
        self::assertEquals(112, $output[1]);
    }
}
