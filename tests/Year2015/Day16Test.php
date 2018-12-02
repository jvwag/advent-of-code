<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2015;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2015\Day16;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2015
 */
class Day16Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day16::class;

    public function testDay16(): void
    {
        $assignment = new Day16();
        $assignment->setInput(
            "Sue 1: perfumes: 1, trees: 6, cats: 8\n" .
            "Sue 2: akitas: 0, trees: 3, perfumes: 1\n" .
            "Sue 3: children: 6, trees: 3, samoyeds: 2\n"
        );
        $output = $assignment->run();

        self::assertSame(2, $output[0]);
        self::assertSame(1, $output[1]);
    }
}
