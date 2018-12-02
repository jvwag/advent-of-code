<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2017\Day18;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day18Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day18::class;

    public function testDay18Part1(): void
    {
        $assignment = new Day18();
        $assignment->setInput(
            "set a 1\n" .
            "add a 2\n" .
            "mul a a\n" .
            "mod a 5\n" .
            "snd a\n" .
            "set a 0\n" .
            "rcv a\n" .
            "jgz a -1\n" .
            "set a 1\n" .
            "jgz a -2\n");
        $output = $assignment->run();

        self::assertEquals(4, $output[0]);
    }

    public function testDay18Part2(): void
    {
        $assignment = new Day18();
        $assignment->setInput(
            "snd 1\n".
            "snd 2\n".
            "snd p\n".
            "rcv a\n".
            "rcv b\n".
            "rcv c\n".
            "rcv d\n"
        );
        $output = $assignment->run();

        self::assertEquals(3, $output[1]);
    }
}
