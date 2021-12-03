<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2021;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2021\Day3;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2021
 */
class Day3Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day3::class;

    public function testDay3(): void
    {
        $assignment = new Day3();
        $assignment->setInput("00100\n11110\n10110\n10111\n10101\n01111\n00111\n11100\n10000\n11001\n00010\n01010\n");
        $output = $assignment->run();

        self::assertEquals(198, $output[0]);
        self::assertEquals(null, $output[1]);
    }
}
