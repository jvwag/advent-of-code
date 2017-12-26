<?php

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Year2017\Day11;
use PHPUnit\Framework\TestCase;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day11Test extends TestCase
{
    /**
     * @param string $input Input
     * @param int $expected1 Expected distance
     * @param int $expected2 Expected maximum distance
     * @dataProvider providerDay11
     */
    public function testDay11($input, $expected1, $expected2)
    {
        $assignment = new Day11();
        $assignment->setInput($input);
        $output = $assignment->run();

        self::assertEquals($expected1, $output[0]);
        self::assertEquals($expected2, $output[1]);
    }

    public function providerDay11()
    {
        return
            [
                ["ne,ne,ne", 3, 3],
                ["ne,ne,sw,sw", 0, 2],
                ["ne,ne,s,s", 2, 2],
                ["se,sw,se,sw,sw", 3, 3],
            ];
    }
}
