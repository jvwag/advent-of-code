<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2018;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2018\Day11;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2018
 */
class Day11Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day11::class;

    /**
     * @dataProvider gridDataProvider
     */
    public function testDay11Grid($serial_number, $x, $y, $expected): void
    {
        $assignment = new Day11();
        $output = $assignment->calculateGrid($serial_number);

        self::assertSame($expected, $output[$x][$y]);
    }

    public function gridDataProvider(): array
    {
        return
            [
                [8, 3, 5, 4],
                [57, 122, 79, -5],
                [39, 217, 196, 0],
                [71, 101, 153, 4],
            ];
    }

    /**
     * @dataProvider squaresDataProvider
     */
    public function testDay11Squares($serial_number, $expected_part1, $expected_part2): void
    {
        $assignment = new Day11();
        $assignment->setInput($serial_number);
        $output = $assignment->run();

        self::assertSame($expected_part1, $output[0]);
        self::assertSame($expected_part2, $output[1]);
    }

    public function squaresDataProvider(): array
    {
        return
            [
                ["18\n", "33,45", "90,269,16"],
                ["42\n", "21,61", "232,251,12"],
            ];
    }
}
