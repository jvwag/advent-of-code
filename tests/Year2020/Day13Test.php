<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2020;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2020\Day13;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2019
 */
class Day13Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day13::class;

    public function testDay13Part1(): void
    {
        $assignment = new Day13();
        $assignment->setInput("939\n7,13,x,x,59,x,31,19\n");
        $output = $assignment->run();

        self::assertEquals(295, $output[0]);
    }

    /**
     * @dataProvider day13part2Provider()
     * @param $expected
     * @param $input
     */
    public function testDay13Part2($expected, $input): void
    {
        $assignment = new Day13();
        $output = $assignment->run2($input);

        self::assertEquals($expected, $output);
    }

    /**
     * @dataProvider day13part2Provider()
     * @param $expected
     * @param $input
     */
    public function testDay13Part2Slow($expected, $input): void
    {
        $assignment = new Day13();
        $output = $assignment->run2_slow($input);

        self::assertEquals($expected, $output);
    }

    public function day13part2Provider(): array
    {
        return [
            [1068781, [0 => 7, 1 => 13, 4 => 59, 6 => 31, 7 => 19]],
            [3417, [0 => 17, 2 => 13, 3 => 19]],
            [754018, [0 => 67, 1 => 7, 2 => 59, 3 => 61]],
            [779210, [0 => 67, 2 => 7, 3 => 59, 4 => 61]],
            [1261476, [0 => 67, 1 => 7, 3 => 59, 4 => 61]],
            [1202161486, [0 => 1789, 1 => 37, 2 => 47, 3 => 1889]],
        ];
    }

}
