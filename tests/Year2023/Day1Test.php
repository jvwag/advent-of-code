<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2023;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2023\Day1;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2022
 */
class Day1Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day1::class;

    public function testDay1(): void
    {
        $assignment = new Day1();
        $assignment->setInput("1abc2\npqr3stu8vwx\na1b2c3d4e5f\ntreb7uchet\n");
        $output = $assignment->run();
        self::assertEquals(142, $output[0]);
    }
    public function testDay1b(): void
    {
        $assignment = new Day1();
        $assignment->setInput("two1nine\neightwothree\nabcone2threexyz\nxtwone3four\n4nineeightseven2\nzoneight234\n7pqrstsixteen\n");
        $output = $assignment->run();
        self::assertEquals(281, $output[1]);
    }
}
