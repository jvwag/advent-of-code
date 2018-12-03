<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2018;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2018\Day3;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2018
 */
class Day3Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day3::class;

    public function testDay4Example1(): void
    {
        $assignment = new Day3();
        $assignment->setInput("#1 @ 1,3: 4x4\n#2 @ 3,1: 4x4\n#3 @ 5,5: 2x2\n");
        $output = $assignment->run();

        self::assertEquals(4, $output[0]);
        self::assertEquals(3, $output[1]);
    }
}
