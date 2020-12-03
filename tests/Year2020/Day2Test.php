<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2020;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2020\Day2;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2020
 */
class Day2Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day2::class;

    public function testDayTemplate(): void
    {
        $assignment = new Day2();

        $data = [
            [1, 3, "a", "abcde"],
            [1, 3, "b", "cdefg"],
            [2, 9, "c", "ccccccccc"],
        ];

        self::assertEquals(2, $assignment->run1($data));
        self::assertEquals(1, $assignment->run2($data));
    }
}
