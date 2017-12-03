<?php

namespace jvwag\AdventOfCode\Tests\Year2015;

use jvwag\AdventOfCode\Year2015\Day9;
use PHPUnit\Framework\TestCase;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2015
 */
class Day9Test extends TestCase
{
    public function testDay9Example()
    {
        $assignment = new Day9();
        $assignment->setInput(
            "London to Dublin = 464\n" .
            "London to Belfast = 518\n" .
            "Dublin to Belfast = 141\n"
        );
        $output = $assignment->run();

        self::assertEquals(605, $output[0]);
        self::assertEquals(982, $output[1]);
    }
}
