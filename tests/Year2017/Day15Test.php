<?php

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Year2017\Day15;
use PHPUnit\Framework\TestCase;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day15Test extends TestCase
{
    public function testDay15()
    {
        $assignment = new Day15();
        $assignment->setInput(
            "Generator A starts with 65\n" .
            "Generator B starts with 8921\n"
        );
        $output = $assignment->run();

        self::assertEquals(588, $output[0]);
        self::assertEquals(309, $output[1]);
    }
}
