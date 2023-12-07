<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2023;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2023\Day7;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2023
 */
class Day7Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day7::class;

    public function testDay7(): void
    {
        $assignment = new Day7();
        $assignment->setInput("32T3K 765\nT55J5 684\nKK677 28\nKTJJT 220\nQQQJA 483\n");
        $output = $assignment->run();

        self::assertEquals(6440, $output[0]);
        self::assertEquals(5905, $output[1]);
    }
}
