<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2015;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2015\Day5;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2015
 */
class Day5Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day5::class;

    /**
     * @dataProvider part1DataProvider
     *
     * @param $input
     * @param $expected
     */
    public function testDay5Part1($input, $expected)
    {
        $assignment = new Day5();
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
                ["ugknbfddgicrmopn", 1],
                ["aaa", 1],
                ["jchzalrnumimnmhp", 0],
                ["haegwjzuvuyypxyu", 0],
                ["dvszwmarrgswjxmb", 0],
            ];
    }

    public function testDay5Part1Combined()
    {
        $assignment = new Day5();
        $assignment->setInput("ugknbfddgicrmopn\naaa\njchzalrnumimnmhp\nhaegwjzuvuyypxyu\ndvszwmarrgswjxmb\n");
        $output = $assignment->run();

        self::assertEquals(2, $output[0]);
    }

    /**
     * @dataProvider part2DataProvider
     *
     * @param $input
     * @param $expected
     */
    public function testDay5Part2($input, $expected)
    {
        $assignment = new Day5();
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
                ["qjhvhtzxzqqjkmpb", 1],
                ["xxyxx", 1],
                ["uurcxstgmygtbstg", 0],
                ["ieodomkazucvgmuy", 0],
            ];
    }

    public function testDay5Part2Combined()
    {
        $assignment = new Day5();
        $assignment->setInput("qjhvhtzxzqqjkmpb\nxxyxx\nuurcxstgmygtbstg\nieodomkazucvgmuy\n");
        $output = $assignment->run();

        self::assertEquals(2, $output[1]);
    }
}
