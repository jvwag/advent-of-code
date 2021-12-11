<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2021;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2021\Day11;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2021
 */
class Day11Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day11::class;

    public function testDay11(): void
    {
        $assignment = new Day11();
        $assignment->setInput("5483143223\n2745854711\n5264556173\n6141336146\n6357385478\n4167524645\n2176841721\n6882881134\n4846848554\n5283751526\n");
        $output = $assignment->run();

        self::assertEquals(1656, $output[0]);
        self::assertEquals(195, $output[1]);
    }
}
