<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2019;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2019\Day10;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2019
 */
class Day10Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day10::class;

    /**
     * @dataProvider providerDay10Part1
     * @param string $input
     * @param int[] $expected
     */
    public function testDay10Part1(string $input, array $expected): void
    {
        $assignment = new Day10();
        $input = $assignment->parseInput($input);
        $output = $assignment->run1($input);

        self::assertEquals($expected, $output);
    }

    public function providerDay10Part1(): array
    {
        return
            [
                [".#..#\n.....\n#####\n....#\n...##\n", [8, 3, 4]],
                ["......#.#.\n#..#.#....\n..#######.\n.#.#.###..\n.#..#.....\n..#....#.#\n#..#....#.\n.##.#..###\n##...#..#.\n.#....####\n", [33, 5, 8]],
                ["#.#...#.#.\n.###....#.\n.#....#...\n##.#.#.#.#\n....#.#.#.\n.##..###.#\n..#...##..\n..##....##\n......#...\n.####.###.\n", [35, 1, 2]],
                [".#..#..###\n####.###.#\n....###.#.\n..###.##.#\n##.##.#.#.\n....###..#\n..#.#..#.#\n#..#.#.###\n.##...##.#\n.....#.#..\n", [41, 6, 3]],
                [
                    ".#..##.###...#######\n##.############..##.\n.#.######.########.#\n.###.#######.####.#.\n#####.##.#.##.###.##\n" .
                    "..#####..#.#########\n####################\n#.####....###.#.#.##\n##.#################\n#####.##.###..####..\n" .
                    "..######..##.#######\n####.##.####...##..#\n.#####..#.######.###\n##...#.##########...\n#.##########.#######\n" .
                    ".####.#.###.###.#.##\n....##.##.###..#####\n.#.#.###########.###\n#.#.#.#####.####.###\n###.##.####.##.#..##\n", [210, 11, 13]]
            ];
    }

    public function testDay10Part2(): void
    {
        $assignment = new Day10();

        $input = $assignment->parseInput($this->providerDay10Part1()[4][0]);
        $output = $assignment->run2($input, 11, 13);

        self::assertEquals(802, $output);

    }
}
