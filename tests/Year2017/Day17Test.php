<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2017\Day17;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day17Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day17::class;

    public function testDay17(): void
    {
        $assignment = new Day17();
        $assignment->setInput("3");
        $output = $assignment->run();

        self::assertEquals(638, $output[0]);
        self::assertEquals(1222153, $output[1]);
    }
}
