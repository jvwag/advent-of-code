<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2015;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2015\Day18;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2015
 */
class Day18Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day18::class;

    /**
     * @dataProvider part1DataProvider
     *
     * @param $input
     * @param $output
     */
    public function testDay18Part1($input, $output)
    {
        self::assertSame(
            $output,
            Day18::gridSaver(
                Day18::step(
                    Day18::gridLoader($input)
                )
            )
        );
    }

    /**
     * @return array
     */
    public function part1DataProvider(): array
    {
        $data = [
            0 =>
                ".#.#.#\n" .
                "...##.\n" .
                "#....#\n" .
                "..#...\n" .
                "#.#..#\n" .
                "####..\n",
            1 =>
                "..##..\n" .
                "..##.#\n" .
                "...##.\n" .
                "......\n" .
                "#.....\n" .
                "#.##..\n",
            2 =>
                "..###.\n" .
                "......\n" .
                "..###.\n" .
                "......\n" .
                ".#....\n" .
                ".#....\n",
            3 =>
                "...#..\n" .
                "......\n" .
                "...#..\n" .
                "..##..\n" .
                "......\n" .
                "......\n",
            4 =>
                "......\n" .
                "......\n" .
                "..##..\n" .
                "..##..\n" .
                "......\n" .
                "......\n",
        ];

        return
            [
                [$data[0], $data[1]],
                [$data[1], $data[2]],
                [$data[2], $data[3]],
                [$data[3], $data[4]],
            ];
    }

    /**
     * @dataProvider part2DataProvider
     *
     * @param $input
     * @param $output
     */
    public function testDay18Part2($input, $output)
    {
        self::assertSame(
            $output,
            Day18::gridSaver(
                Day18::lock(
                    Day18::step(
                        Day18::lock(
                            Day18::gridLoader($input)
                        )
                    )
                )
            )
        );
    }

    /**
     * @return array
     */
    public function part2DataProvider(): array
    {
        $data = [
            0 =>
                "##.#.#\n" .
                "...##.\n" .
                "#....#\n" .
                "..#...\n" .
                "#.#..#\n" .
                "####.#\n",
            1 =>
                "#.##.#\n" .
                "####.#\n" .
                "...##.\n" .
                "......\n" .
                "#...#.\n" .
                "#.####\n",
            2 =>
                "#..#.#\n" .
                "#....#\n" .
                ".#.##.\n" .
                "...##.\n" .
                ".#..##\n" .
                "##.###\n",
            3 =>
                "#...##\n" .
                "####.#\n" .
                "..##.#\n" .
                "......\n" .
                "##....\n" .
                "####.#\n",
            4 =>
                "#.####\n" .
                "#....#\n" .
                "...#..\n" .
                ".##...\n" .
                "#.....\n" .
                "#.#..#\n",
            5 =>
                "##.###\n" .
                ".##..#\n" .
                ".##...\n" .
                ".##...\n" .
                "#.#...\n" .
                "##...#\n",
        ];

        return
            [
                [$data[0], $data[1]],
                [$data[1], $data[2]],
                [$data[2], $data[3]],
                [$data[3], $data[4]],
                [$data[4], $data[5]],
            ];
    }
}
