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

    public function day13part2Provider(): array
    {
        return [
            [1068781, [7, 13, 0, 0, 59, 0, 31, 19]],
            [3417, [17, 0, 13, 19]],
            [754018, [67, 7, 59, 61]],
            [779210, [67, 0, 7, 59, 61]],
            [1261476, [67, 7, 0, 59, 61]],
            [1202161486, [1789, 37, 47, 1889]],
        ];
    }

}
