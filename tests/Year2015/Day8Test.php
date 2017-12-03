<?php

namespace jvwag\AdventOfCode\Tests\Year2015;

use jvwag\AdventOfCode\Year2015\Day8;
use PHPUnit\Framework\TestCase;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2015
 */
class Day8Test extends TestCase
{
    public function testDay8Example()
    {
        $assignment = new Day8();
        $assignment->setInput(
            '""' . "\n" .
            '"abc"' . "\n" .
            '"aaa\"aaa"' . "\n" .
            '"\x27"' . "\n"
        );
        $output = $assignment->run();

        self::assertEquals(12, $output[0]);
        self::assertEquals(19, $output[1]);
    }
}
