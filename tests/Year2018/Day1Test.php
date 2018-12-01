<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2018;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2018\Day1;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2018
 */
class Day1Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day1::class;

    /**
     * @dataProvider part1DataProvider
     * @param int[] $input
     * @param int $expected
     */
    public function testDay1Part1Examples($input, $expected): void
    {
        $assignment = new Day1();
        $output = $assignment->run1($input);

        self::assertSame($expected, $output);
    }

    /**
     * @return array
     */
    public function part1DataProvider(): array
    {
        return
            [
                [[1, -2, 3, 1], 3],
                [[1, 1, 1], 3],
                [[1, 1, -2], 0],
                [[-1, -2, -3], -6],
            ];
    }

    /**
     * @dataProvider part2DataProvider
     * @param int[] $input
     * @param int $expected
     */
    public function testDay1Part2Examples($input, $expected): void
    {
        $assignment = new Day1();
        $output = $assignment->run2($input);

        self::assertSame($expected, $output);
    }

    /**
     * @return array
     */
    public function part2DataProvider(): array
    {
        return
            [
                [[1, -2, 3, 1], 2],
                [[1, -1], 0],
                [[3, 3, 4, -2, -4], 10],
                [[7, 7, -2, -7, -4], 14],
            ];
    }
}

