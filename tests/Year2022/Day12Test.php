<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2022;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2022\Day12;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2022
 */
class Day12Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day12::class;

    public function testDay12(): void
    {
        $assignment = new Day12();
        $assignment->setInput("Sabqponm\nabcryxxl\naccszExk\nacctuvwj\nabdefghi\n");
        $output = $assignment->run();

        self::assertEquals(31, $output[0]);
        self::assertEquals(29, $output[1]);
    }
}
