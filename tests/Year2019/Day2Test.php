<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2019;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2019\Day2;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2019
 */
class Day2Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day2::class;

    /**
     * @dataProvider part1DataProvider
     * @param int[] $input
     * @param int $expected
     */
    public function testDay2Part1Examples($input, $expected): void
    {
        $assignment = new Day2();
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
                [[1,12,2,0,99,0,0,0,0,0,0,0,8], 10],
                [[2,12,2,0,99,0,0,0,0,0,0,0,33], 66],
            ];
    }

    /**
     * @dataProvider part2DataProvider
     * @param int[] $input
     * @param int $expected
     */
    public function testDay2Part2Examples($input, $expected): void
    {
        $assignment = new Day2();
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
                [[1,0,0,0,99,19690620,100], 506],
                [[2,0,0,0,99,0,0,0,0,0,0,984536,20], 1112],
            ];
    }
}
