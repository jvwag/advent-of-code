<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2015;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2015\Day10;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2015
 */
class Day10Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day10::class;

    public function testDay10()
    {
        $assignment = new Day10();

        self::assertSame("11", $assignment->lookAndSay("1"));
        self::assertSame("21", $assignment->lookAndSay("11"));
        self::assertSame("1211", $assignment->lookAndSay("21"));
        self::assertSame("111221", $assignment->lookAndSay("1211"));
        self::assertSame("312211", $assignment->lookAndSay("111221"));
    }
}
