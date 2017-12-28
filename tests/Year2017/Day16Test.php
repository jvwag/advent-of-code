<?php

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Year2017\Day16;
use PHPUnit\Framework\TestCase;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day16Test extends TestCase
{
    public function testDay16()
    {
        $assignment = new Day16();
        $input = "s1,x3/4,pe/b";

        self::assertEquals("baedc", $assignment->pass("abcde", $input));
        self::assertEquals("ceadb", $assignment->pass("baedc", $input));
        self::assertEquals("ceadb", $assignment->pass("abcde", $input, 2));
    }
}
