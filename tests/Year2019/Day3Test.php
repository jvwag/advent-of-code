<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2019;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2019\Day3;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2019
 */
class Day3Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day3::class;

    /**
     * @dataProvider part1DataProvider
     * @param int[] $input
     * @param int $expected
     */
    public function testDay3Part1Examples($input, $expected): void
    {
        $assignment = new Day3();
        $output = $assignment->calc($input)[0];

        self::assertSame($expected, $output);
    }

    /**
     * @return array
     */
    public function part1DataProvider(): array
    {
        return
            [
                [[["R8","U5","L5","D3"],["U7","R6","D4","L4"]], 6],
                [[["R75","D30","R83","U83","L12","D49","R71","U7","L72"],["U62","R66","U55","R34","D71","R55","D58","R83"]], 159],
                [[["R98","U47","R26","D63","R33","U87","L62","D20","R33","U53","R51"],["U98","R91","D20","R16","D67","R40","U7","R15","U6","R7"]], 135]
            ];
    }

    /**
     * @dataProvider part2DataProvider
     * @param int[] $input
     * @param int $expected
     */
    public function testDay3Part2Examples($input, $expected): void
    {
        $assignment = new Day3();
        $output = $assignment->calc($input)[1];

        self::assertSame($expected, $output);
    }

    /**
     * @return array
     */
    public function part2DataProvider(): array
    {
        return
            [
                [[["R8","U5","L5","D3"],["U7","R6","D4","L4"]], 30],
                [[["R75","D30","R83","U83","L12","D49","R71","U7","L72"],["U62","R66","U55","R34","D71","R55","D58","R83"]], 610],
                [[["R98","U47","R26","D63","R33","U87","L62","D20","R33","U53","R51"],["U98","R91","D20","R16","D67","R40","U7","R15","U6","R7"]], 410]
            ];
    }
}
