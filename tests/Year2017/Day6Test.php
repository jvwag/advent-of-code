<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2017\Day6;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day6Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day6::class;

    public function testDay6()
    {
        $assignment = new Day6();
        $assignment->setInput("0\t2\t7\t0");
        $output = $assignment->run();

        self::assertEquals(5, $output[0]);
        self::assertEquals(4, $output[1]);
    }
}
