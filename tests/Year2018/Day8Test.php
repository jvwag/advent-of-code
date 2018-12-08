<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2018;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2018\Day8;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2018
 */
class Day8Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day8::class;

    public function testDay8(): void
    {
        $assignment = new Day8();
        $assignment->setInput("2 3 0 3 10 11 12 1 1 0 1 99 2 1 1 2\n");
        $output = $assignment->run();

        self::assertEquals(138, $output[0]);
        self::assertEquals(66, $output[1]);
    }
}
