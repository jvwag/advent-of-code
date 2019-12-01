<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2019;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2019\Day1;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2019
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
                [[12], 2],
                [[14], 2],
                [[1969], 654],
                [[100756], 33583],
                [[12, 14, 1969, 100756], 2 + 2 + 654 + 33583]
            ];
    }

    /**
     * @dataProvider part1DataProvider
     * @param int[] $input
     * @param int $expected
     */
    public function testDay1Part2Examples($input, $expected): void
    {
        $assignment = new Day1();
        $output = $assignment->run1($input);

        self::assertSame($expected, $output);
    }

    /**
     * @return array
     */
    public function part2DataProvider(): array
    {
        return
            [
                [[12], 2],
                [[14], 2],
                [[1969], 966],
                [[100756], 50346],
                [[12, 14, 1969, 100756], 2 + 2 + 966 + 50346]
            ];
    }
}
