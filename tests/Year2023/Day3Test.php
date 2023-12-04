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

    public function testDay3(): void
    {
        $assignment = new Day3();
        $assignment->setInput(
            "467..114..\n...*......\n..35..633.\n......#...\n617*......\n" .
            ".....+.58.\n..592.....\n......755.\n...$.*....\n.664.598..\n");
        $output = $assignment->run();

        self::assertEquals(4361, $output[0]);
        self::assertEquals(467835, $output[1]);
    }

    public function testDay3Reddit(): void
    {
        $assignment = new Day3();
        $assignment->setInput(
            "12.......*..\n+.........34\n.......-12..\n..78........\n..*....60...\n78.........9\n.5.....23..$\n8...90*12...\n............\n2.2......12.\n.*.........*\n1.1..503+.56\n");
        $output = $assignment->run();

        self::assertEquals(925, $output[0]);
        self::assertEquals(6756, $output[1]);
    }
    public function testDay3Paul(): void
    {
        $assignment = new Day3();
        $assignment->setInput(file_get_contents(__DIR__."/../../downloads/year2023-day3-paul.txt"));
        $output = $assignment->run();

        self::assertEquals(550934 , $output[0]);
        self::assertEquals(81997870, $output[1]);
    }
}
