<?php

namespace jvwag\AdventOfCode\Tests\Year2015;

use jvwag\AdventOfCode\Year2015\Day11;
use PHPUnit\Framework\TestCase;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2015
 */
class Day11Test extends TestCase
{
    public function testDayX()
    {
        self::markTestSkipped("Skipping long test");

        $assignment = new Day11();

        self::assertSame("abcdffaa", $assignment->newPassword("abcdefgh"));
        self::assertSame("ghjaabcc", $assignment->newPassword("ghijklmn"));
    }
}
