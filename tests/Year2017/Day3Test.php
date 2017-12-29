<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2017\Day3;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day3Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day3::class;

    /**
     * @dataProvider part1DataProvider
     *
     * @param $input
     * @param $expected
     */
    public function testDay3Part1($input, $expected)
    {
        $assignment = new Day3();
        $assignment->setInput($input);
        $output = $assignment->run();

        self::assertSame($expected, $output[0]);
    }

    /**
     * @return array
     */
    public function part1DataProvider(): array
    {
        return
            [
                ["1", 0],
                ["12", 3],
                ["23", 2],
                ["1024", 31],
            ];
    }

    /**
     * @dataProvider part2DataProvider
     *
     * @param $input
     * @param $expected
     */
    public function testDay3Part2($input, $expected)
    {
        $assignment = new Day3();
        $assignment->setInput($input);
        $output = $assignment->run();

        self::assertSame($expected, $output[1], "Input: ".$input);
    }

    /**
     * @return array
     */
    public function part2DataProvider(): array
    {
        return
            [
                ["6", 10],
                ["7", 10],
                ["8", 10],
                ["9", 10],
                ["10", 11],
                ["11", 23],
                ["22", 23],
                ["23", 25],
                ["24", 25],
                ["25", 26],
            ];
    }
}
