<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2016;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2016\Day2;

/**
 * Class Day2Test
 *
 * @package jvwag\AdventOfCode\Tests\Year2016
 */
class Day2Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day2::class;

    private $example = "ULL\nRRDDD\nLURDL\nUUUUD";

    public function testDay2Part1Example1(): void
    {
        $assignment = new Day2();
        $assignment->setInput($this->example);
        $output = $assignment->run();

        static::assertEquals("1985", $output[0]);
    }

    public function testDay2Part2Example1(): void
    {
        $assignment = new Day2();
        $assignment->setInput($this->example);
        $output = $assignment->run();

        static::assertEquals("5DB3", $output[1]);
    }
}
