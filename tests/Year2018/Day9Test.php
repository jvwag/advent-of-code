<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2018;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2018\Day9;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2018
 */
class Day9Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day9::class;

    /**
     * @dataProvider day9DataProvider
     * @param string $input
     * @param int $expected_part1
     * @param null $expected_part2
     */
    public function testDay9(string $input, int $expected_part1, $expected_part2): void
    {
        $assignment = new Day9();
        $assignment->setInput($input);
        $output = $assignment->run();

        self::assertEquals($expected_part1, $output[0]);
        if ($expected_part2 !== null) {
            self::assertEquals($expected_part2, $output[1]);
        }
    }

    /**
     * @return array
     */
    public function day9DataProvider(): array
    {
        return
            [
                ["10 players; last marble is worth 1618 points", 8317, null],
                ["13 players; last marble is worth 7999 points", 146373, null],
                ["17 players; last marble is worth 1104 points", 2764, null],
                ["21 players; last marble is worth 6111 points", 54718, null],
                ["30 players; last marble is worth 5807 points", 37305, null],
            ];
    }
}
