<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2023;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2023\Day3;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2023
 */
class Day3Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day3::class;

    public function testDayTemplate(): void
    {
        $assignment = new Day3();
        $assignment->setInput(
            "467..114..\n...*......\n..35..633.\n......#...\n617*......\n" .
            ".....+.58.\n..592.....\n......755.\n...$.*....\n.664.598..\n");
        $output = $assignment->run();

        self::assertEquals(4361, $output[0]);
        self::assertEquals(467835, $output[1]);
    }
}
