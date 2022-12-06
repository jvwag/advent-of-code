<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2022;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2022\Day6;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2022
 */
class Day6Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day6::class;

    /**
     * @dataProvider part1Provider
     */
    public function testDay6Part1($input, $expected): void
    {
        $assignment = new Day6();
        $assignment->setInput($input);
        $output = $assignment->run();

        self::assertEquals($expected, $output[0]);
    }

    /**
     * @dataProvider part2Provider
     */
    public function testDay6Part2($input, $expected): void
    {
        $assignment = new Day6();
        $assignment->setInput($input);
        $output = $assignment->run();

        self::assertEquals($expected, $output[1]);
    }

    public function part1Provider(): array
    {
        return [
            ["bvwbjplbgvbhsrlpgdmjqwftvncz", 5],
            ["nppdvjthqldpwncqszvftbrmjlhg", 6],
            ["nznrnfrfntjfmvfwmzdfjlvtqnbhcprsg", 10],
            ["zcfzfwzzqfrljwzlrfnpqdbhtmscgvjw", 11]
        ];
    }

    public function part2Provider(): array
    {
        return [
            ["mjqjpqmgbljsphdztnvjfqwrcgsmlb", 19],
            ["bvwbjplbgvbhsrlpgdmjqwftvncz", 23],
            ["nppdvjthqldpwncqszvftbrmjlhg", 23],
            ["nznrnfrfntjfmvfwmzdfjlvtqnbhcprsg", 29],
            ["zcfzfwzzqfrljwzlrfnpqdbhtmscgvjw", 26]
        ];
    }
}
