<?php

namespace jvwag\AdventOfCode\Tests\Year2016;

use jvwag\AdventOfCode\Year2016\Day4;
use PHPUnit\Framework\TestCase;

/**
 * Class Day4Test
 *
 * @package jvwag\AdventOfCode\Tests\Year2016
 */
class Day4Test extends TestCase
{
    public function testDay1Part1Example1()
    {
        $assignment = new Day4();
        $assignment->setInput(
            "aaaaa-bbb-z-y-x-123[abxyz]\n" .
            "a-b-c-d-e-f-g-h-987[abcde]\n" .
            "not-a-real-room-404[oarel]\n" .
            "totally-real-room-200[decoy]\n"
        );
        $output = $assignment->run();

        static::assertEquals(1514, $output[0]);
    }

    public function testDay1Part2Test1()
    {
        $assignment = new Day4();
        $assignment->setInput(
            "aaaaa-bbb-z-y-x-123[abxyz]\n" .
            "northpole-object-storage-26[oetra]\n"
        );
        $output = $assignment->run();

        //$this->assertEquals(1, $output[0]);
        static::assertEquals(149, $output[0]);
        static::assertEquals(26, $output[1]);
    }
}
