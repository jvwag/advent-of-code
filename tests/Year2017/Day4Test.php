<?php

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Year2017\Day4;
use PHPUnit\Framework\TestCase;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day4Test extends TestCase
{
    /**
     * @dataProvider part1DataProvider
     *
     * @param $input
     * @param $expected
     */
    public function testDay3Part1($input, $expected)
    {
        $assignment = new Day4();
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
                ["aa bb cc dd ee", 1],
                ["aa bb cc dd aa", 0],
                ["aa bb cc dd aaa", 1],
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
        $assignment = new Day4();
        $assignment->setInput($input);
        $output = $assignment->run();

        self::assertSame($expected, $output[1], $input);
    }

    /**
     * @return array
     */
    public function part2DataProvider(): array
    {
        return
            [
//                ["abcde fghij", 1],
                ["abcde xyz ecdab", 0],
                ["a ab abc abd abf abj", 1],
                ["iiii oiii ooii oooi oooo", 1],
                ["oiii ioii iioi iiio", 0],
            ];
    }
}