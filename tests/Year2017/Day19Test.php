<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Year2017\Day19;
use PHPUnit\Framework\TestCase;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day19Test extends TestCase
{
    public function testDay19()
    {
        $assignment = new Day19();
        $assignment->setInput(
            "     |          \n" .
            "     |  +--+    \n" .
            "     A  |  C    \n" .
            " F---|----E|--+ \n" .
            "     |  |  |  D \n" .
            "     +B-+  +--+ \n" .
            "                \n"
        );
        $output = $assignment->run();

        self::assertEquals("ABCDEF", $output[0]);
        self::assertEquals(38, $output[1]);
    }
}
