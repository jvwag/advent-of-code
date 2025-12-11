<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2025;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2025\Day11;

class Day11Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day11::class;

    public function testDay11(): void
    {
        $assignment = new Day11();
        $assignment->setInput(
            "aaa: you hhh\n" .
            "you: bbb ccc\n" .
            "bbb: ddd eee\n" .
            "ccc: ddd eee fff\n" .
            "ddd: ggg\n" .
            "eee: out\n" .
            "fff: out\n" .
            "ggg: out\n" .
            "hhh: ccc fff iii\n" .
            "iii: out\n"
        );
        $output = $assignment->run();

        self::assertEquals(5, $output[0]);
    }

    public function testDay11b(): void
    {
        $assignment = new Day11();
        $assignment->setInput(
            "svr: aaa bbb\n" .
            "aaa: fft\n" .
            "fft: ccc\n" .
            "bbb: tty\n" .
            "tty: ccc\n" .
            "ccc: ddd eee\n" .
            "ddd: hub\n" .
            "hub: fff\n" .
            "eee: dac\n" .
            "dac: fff\n" .
            "fff: ggg hhh\n" .
            "ggg: out\n" .
            "hhh: out\n"
        );
        $output = $assignment->run();

        self::assertEquals(2, $output[1]);
    }
}
