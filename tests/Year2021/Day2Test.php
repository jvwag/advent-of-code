<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2021;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2021\Day2;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2021
 */
class Day2Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day2::class;

    public function testDay2(): void
    {
        $assignment = new Day2();
        $assignment->setInput("forward 5\ndown 5\nforward 8\nup 3\ndown 8\nforward 2\n");
        $output = $assignment->run();

        self::assertEquals(150, $output[0]);
        self::assertEquals(900, $output[1]);
    }
}
