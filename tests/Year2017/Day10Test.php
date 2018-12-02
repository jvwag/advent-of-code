<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2017\Day10;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day10Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day10::class;

    public function testDay10Part1(): void
    {
        $assignment = new Day10();
        $output = $assignment->run1("3,4,1,5", 5);

        self::assertEquals(12, $output);
    }

    /**
     * @dataProvider providerPart2
     * @param $input
     * @param $expected
     */
    public function testDay10Part2($input, $expected): void
    {
        $assignment = new Day10();
        $output = $assignment->run2($input);

        self::assertEquals($expected, $output);
    }

    /**
     * @return array
     */
    public function providerPart2(): array
    {
        return
            [
                ["AoC 2017", "33efeb34ea91902bb2f59c9920caa6cd"],
                ["1,2,3", "3efbe78a8d82f29979031a4aa0b16a9d"],
                ["1,2,4", "63960835bcdc130f0b66d7ff4f6a5a8e"],
            ];
    }
}
