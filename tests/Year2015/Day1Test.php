<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2015;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2015\Day1;

/**
 * Class Day1Test
 *
 * @package jvwag\AdventOfCode\Tests\Year2015
 */
class Day1Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day1::class;

    /**
     * @dataProvider part1DataProvider
     *
     * @param $input
     * @param $expected
     */
    public function testDay1Part1($input, $expected): void
    {
        $assignment = new Day1();
        $assignment->setInput($input);
        $output = $assignment->run();

        self::assertEquals($expected, $output[0]);
    }

    /**
     * @return array
     */
    public function part1DataProvider(): array
    {
        return
            [
                ["(())", 0],
                ["()()", 0],
                ["(((", 3],
                ["(()(()(", 3],
                ["))(((((", 3],
                ["())", -1],
                ["))(", -1],
                [")))", -3],
                [")())())", -3],
            ];
    }

    /**
     * @dataProvider part2DataProvider
     *
     * @param $input
     * @param $expected
     */
    public function testDay1Part2($input, $expected): void
    {
        $assignment = new Day1();
        $assignment->setInput($input);
        $output = $assignment->run();

        self::assertEquals($expected, $output[1]);
    }

    /**
     * @return array
     */
    public function part2DataProvider(): array
    {
        return
            [
                [")", 1],
                ["()())", 5],
            ];
    }
}
