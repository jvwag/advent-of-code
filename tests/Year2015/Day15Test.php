<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2015;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2015\Day15;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2015
 */
class Day15Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day15::class;

    public function testDay15(): void
    {
        $assignment = new Day15();
        $assignment->setInput(
            "Butterscotch: capacity -1, durability -2, flavor 6, texture 3, calories 8\n" .
            "Cinnamon: capacity 2, durability 3, flavor -2, texture -1, calories 3\n"
        );
        $output = $assignment->run();

        self::assertEquals(62842880, $output[0]);
        self::assertEquals(57600000, $output[1]);
    }
}
