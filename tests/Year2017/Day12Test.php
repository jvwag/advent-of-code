<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2017\Day12;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day12Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day12::class;

    public function testDay12()
    {
        $assignment = new Day12();
        $assignment->setInput(
            "0 <-> 2\n" .
            "1 <-> 1\n" .
            "2 <-> 0, 3, 4\n" .
            "3 <-> 2, 4\n" .
            "4 <-> 2, 3, 6\n" .
            "5 <-> 6\n" .
            "6 <-> 4, 5\n"
        );
        $output = $assignment->run();

        self::assertEquals(6, $output[0]);
        self::assertEquals(2, $output[1]);
    }
}
