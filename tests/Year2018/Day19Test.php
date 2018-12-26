<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2018;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2018\Day19;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2018
 */
class Day19Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day19::class;

    public function testDay19(): void
    {
        $assignment = new Day19();

        [$program, $ip_reg] = $assignment->parse(
            "#ip 0\n" .
            "seti 5 0 1\n" .
            "seti 6 0 2\n" .
            "addi 0 1 0\n" .
            "addr 1 2 3\n" .
            "setr 1 0 0\n" .
            "seti 8 0 4\n" .
            "seti 9 0 5\n");

        $output = $assignment->execute($program, [0, 0, 0, 0, 0, 0], $ip_reg);

        self::assertSame([7, 5, 6, 0, 0, 9], $output);
    }
}
