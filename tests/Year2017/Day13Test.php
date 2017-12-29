<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2017\Day13;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day13Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day13::class;

    public function testDay13()
    {
        $assignment = new Day13();
        $assignment->setInput(
            "0: 3\n" .
            "1: 2\n" .
            "4: 4\n" .
            "6: 4\n"
        );
        $output = $assignment->run();

        self::assertEquals(24, $output[0]);
        self::assertEquals(10, $output[1]);
    }
}
