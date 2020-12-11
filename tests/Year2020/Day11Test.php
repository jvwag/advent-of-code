<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2020;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2020\Day11;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2019
 */
class Day11Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day11::class;

    public function testDay11(): void
    {
        $assignment = new Day11();
        $assignment->setInput(
            "L.LL.LL.LL\n".
            "LLLLLLL.LL\n".
            "L.L.L..L..\n".
            "LLLL.LL.LL\n".
            "L.LL.LL.LL\n".
            "L.LLLLL.LL\n".
            "..L.L.....\n".
            "LLLLLLLLLL\n".
            "L.LLLLLL.L\n".
            "L.LLLLL.LL\n");
        $output = $assignment->run();

        self::assertEquals(37, $output[0]);
        self::assertEquals(26, $output[1]);
    }
}
