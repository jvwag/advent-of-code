<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2021;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2021\Day15;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2021
 */
class Day15Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day15::class;

    public function testDay15(): void
    {
        $assignment = new Day15();
        $assignment->setInput(
            "1163751742\n" .
            "1381373672\n" .
            "2136511328\n" .
            "3694931569\n" .
            "7463417111\n" .
            "1319128137\n" .
            "1359912421\n" .
            "3125421639\n" .
            "1293138521\n" .
            "2311944581\n"
        );
        $output = $assignment->run();

        self::assertEquals(40, $output[0]);
        self::assertEquals(315, $output[1]);
    }
}
