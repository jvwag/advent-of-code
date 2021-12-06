<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2021;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2021\Day6;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2021
 */
class Day6Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day6::class;

    public function testDay6(): void
    {
        $assignment = new Day6();
        $assignment->setInput("3,4,3,1,2\n");
        $output = $assignment->run();

        self::assertEquals(5934, $output[0]);
        self::assertEquals(26984457539, $output[1]);
    }
}
