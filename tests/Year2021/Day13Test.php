<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2021;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2021\Day13;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2021
 */
class Day13Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day13::class;

    public function testDay13(): void
    {
        $assignment = new Day13();
        $assignment->setInput(
            "6,10\n0,14\n9,10\n0,3\n10,4\n4,11\n6,0\n6,12\n4,1\n0,13\n10,12\n3,4\n3,0\n8,4\n1,10\n2,14\n8,10\n9,0\n\n" .
            "fold along y=7\n" .
            "fold along x=5\n");
        $output = $assignment->run();

        self::assertEquals(17, $output[0]);
        self::assertEquals(
            "#####\n" .
            "#...#\n" .
            "#...#\n" .
            "#...#\n" .
            "#####\n".
            ".....\n" .
            ".....\n", $output[1]);
    }
}
