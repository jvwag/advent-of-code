<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2020;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2020\Day1;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2020
 */
class Day1Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day1::class;

    public function testDayTemplate(): void
    {
        $assignment = new Day1();

        self::assertEquals(77, $assignment->run1([1, 2, 11, 3, 4, 22, 5, 7], 18));
        self::assertEquals(1694, $assignment->run2([1, 2, 11, 3, 4, 22, 5, 7], 40));
    }
}
