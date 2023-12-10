<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2023;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2023\Day10;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2023
 */
class Day10Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day10::class;

    public function testDay10(): void
    {
        $assignment = new Day10();
        $assignment->setInput(".....\n.S-7.\n.|.|.\n.L-J.\n.....\n");
        $output = $assignment->run();

        self::assertEquals(4, $output[0]);
    }

    public function testDay10b(): void
    {
        $assignment = new Day10();
        $assignment->setInput("..F7.\n.FJ|.\nSJ.L7\n|F--J\nLJ...\n");
        $output = $assignment->run();

        self::assertEquals(8, $output[0]);
    }
}
