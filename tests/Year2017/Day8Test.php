<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2017\Day8;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day8Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day8::class;

    public function testDay8()
    {
        $assignment = new Day8();
        $assignment->setInput(
            "b inc 5 if a > 1\n" .
            "a inc 1 if b < 5\n" .
            "c dec -10 if a >= 1\n" .
            "c inc -20 if c == 10\n"
        );
        $output = $assignment->run();

        self::assertEquals(1, $output[0]);
        self::assertEquals(10, $output[1]);
    }
}
