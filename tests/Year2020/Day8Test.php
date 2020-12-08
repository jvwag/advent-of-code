<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2020;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2020\Day8;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2019
 */
class Day8Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day8::class;

    public function testDay8(): void
    {
        $assignment = new Day8();
        $assignment->setInput(
            "nop +0\n" .
            "acc +1\n" .
            "jmp +4\n" .
            "acc +3\n" .
            "jmp -3\n" .
            "acc -99\n" .
            "acc +1\n" .
            "jmp -4\n" .
            "acc +6\n");
        $output = $assignment->run();

        self::assertEquals(5, $output[0]);
        self::assertEquals(8, $output[1]);
    }
}
