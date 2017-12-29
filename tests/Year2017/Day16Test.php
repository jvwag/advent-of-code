<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2017\Day16;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day16Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day16::class;

    public function testDay16()
    {
        $assignment = new Day16();
        $input = "s1,x3/4,pe/b";

        self::assertEquals("baedc", $assignment->pass("abcde", $input));
        self::assertEquals("ceadb", $assignment->pass("baedc", $input));
        self::assertEquals("ceadb", $assignment->pass("abcde", $input, 2));
    }
}
