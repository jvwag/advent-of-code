<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2021;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2021\Day20;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2021
 */
class Day20Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day20::class;

    public function testDay20(): void
    {

        $assignment = new Day20();
        $assignment->setInput(
            "..#.#..#####.#.#.#.###.##.....###.##.#..###.####..#####..#....#..#..##..##" .
            "#..######.###...####..#..#####..##..#.#####...##.#.#..#.##..#.#......#.###" .
            ".######.###.####...#.##.##..#..#..#####.....#.#....###..#.##......#.....#." .
            ".#..#..##..#...##.######.####.####.#.#...#.......#..#.#.#...####.##.#....." .
            ".#..#...##.#.##..#...##.#.##..###.#......#.#.......#.#.#.####.###.##...#.." .
            "...####.#..#..#.##.#....##..#.####....##...##..#...#......#.#.......#....." .
            "..##..####..#...#.#.#...##..#.#..###..#####........#..####......#..#\n\n" .
            "#..#.\n" .
            "#....\n" .
            "##..#\n" .
            "..#..\n" .
            "..###\n");
        $output = $assignment->run();

        self::assertEquals(35, $output[0]);
        self::assertEquals(3351, $output[1]);
    }
}
