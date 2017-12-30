<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2017\Day22;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day22Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day22::class;

    public function testDay22()
    {
        $assignment = new Day22();
        $assignment->setInput("..#\n#..\n...\n");
        $output = $assignment->run();

        self::assertEquals(5587, $output[0]);
        self::assertEquals(2511944, $output[1]);
    }

    public function testDay22bis()
    {
        $assignment = new Day22();
        $assignment->setInput("..#\n#..\n...\n");

        $grid = $assignment->readGrid();
        $output = $assignment->run2($grid, 100);

        self::assertEquals(26, $output);
    }
}
