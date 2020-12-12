<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2020;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2020\Day12;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2019
 */
class Day12Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day12::class;

    public function testDay12(): void
    {
        $assignment = new Day12();
        $assignment->setInput("F10\nN3\nF7\nR90\nF11\n");
        $output = $assignment->run();

        self::assertEquals(25, $output[0]);
        self::assertEquals(286, $output[1]);
    }
}
