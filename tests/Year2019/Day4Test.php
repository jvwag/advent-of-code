<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2019;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2019\Day4;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2019
 */
class Day4Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day4::class;

    public function testDay4Part1Examples(): void
    {
        $assignment = new Day4();
        self::assertSame(["111111"], array_values($assignment->filter1(["111111", "223450", "123789"])));
    }

    public function testDay4Part2Examples(): void
    {
        $assignment = new Day4();
        self::assertSame(["112233", "111122"], array_values($assignment->filter2($assignment->filter1(["112233", "123444", "111122"]))));
    }
}
