<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2020;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2020\Day14;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2019
 */
class Day14Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day14::class;

    public function testDay14part1(): void
    {
        $assignment = new Day14();
        $input =
            [
                "mask = XXXXXXXXXXXXXXXXXXXXXXXXXXXXX1XXXX0X",
                "mem[8] = 11",
                "mem[7] = 101",
                "mem[8] = 0",
            ];

        self::assertEquals(165, $assignment->run1($input));
    }

    public function testDay14part2(): void
    {
        $assignment = new Day14();
        $input =
            [
                "mask = 000000000000000000000000000000X1001X",
                "mem[42] = 100",
                "mask = 00000000000000000000000000000000X0XX",
                "mem[26] = 1",
            ];

        self::assertEquals(208, $assignment->run2($input));
    }
}
