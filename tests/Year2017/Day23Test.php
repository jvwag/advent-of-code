<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2017\Day23;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day23Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day23::class;

    public function testDay23()
    {
        $assignment = new Day23();
        $assignment->setInput(
            "set a 10\n".
            "mul a 10\n".
            "mul a 10\n".
            "mul a 10\n".
            "mul a 10\n".
            "mul a 10\n".
            "set b 1\n".
            "set c 1000\n"

        );
        $output = $assignment->run();

        self::assertEquals(5, $output[0]);
        self::assertEquals(48, $output[1]);
    }
}
