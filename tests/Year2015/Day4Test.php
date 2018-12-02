<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2015;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2015\Day4;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2015
 */
class Day4Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day4::class;

    public function testDay4Part1Example1(): void
    {
        $assignment = new Day4();
        $assignment->setInput("abcdef");
        $output = $assignment->run();

        self::assertEquals(609043, $output[0]);
    }

    public function testDay4Part1Example2(): void
    {
        $assignment = new Day4();
        $assignment->setInput("pqrstuv");
        $output = $assignment->run();

        self::assertEquals(1048970, $output[0]);
    }
}
