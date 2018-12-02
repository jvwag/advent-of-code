<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2015;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2015\Day14;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2015
 */
class Day14Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day14::class;

    public function testDay14(): void
    {
        $assignment = new Day14();
        $assignment->setInput(
            "Dancer can fly 14 km/s for 10 seconds, but then must rest for 127 seconds.\n" .
            "Cupid can fly 16 km/s for 11 seconds, but then must rest for 162 seconds.\n"
        );
        $output = $assignment->calculate(1000);

        self::assertEquals(1120, $output[0]);
        self::assertEquals(689, $output[1]);
    }
}
