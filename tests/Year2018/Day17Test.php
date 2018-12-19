<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2018;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2018\Day17;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2018
 */
class Day17Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day17::class;

    public function testDay17(): void
    {
        $assignment = new Day17();
        $assignment->setInput(
            "x=495, y=2..7\n" .
            "y=7, x=495..501\n" .
            "x=501, y=3..7\n" .
            "x=498, y=2..4\n" .
            "x=506, y=1..2\n" .
            "x=498, y=10..13\n" .
            "x=504, y=10..13\n" .
            "y=13, x=498..504\n");
        $output = $assignment->run();

        self::assertEquals(57, $output[0]);
        self::assertEquals(29, $output[1]);
    }

    public function testDay17BucketInBucket(): void
    {
        $assignment = new Day17();
        $assignment->setInput(
            "x=495, y=2..12\n" .
            "y=12, x=495..511\n" .
            "x=511, y=3..12\n" .
            "x=503, y=5..8\n".
            "y=8, x=503..506\n" .
            "x=506, y=5..8\n"
        );
        $output = $assignment->run();

        self::assertEquals(153, $output[0]);
        self::assertEquals(125, $output[1]);
    }
}
