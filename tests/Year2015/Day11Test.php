<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2015;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2015\Day11;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2015
 */
class Day11Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day11::class;

    public function testDay11()
    {
        $assignment = new Day11();

        self::assertSame("abcdffaa", $assignment->newPassword("abcdefgh"));
        self::assertSame("ghjaabcc", $assignment->newPassword("ghijklmn"));
    }
}
