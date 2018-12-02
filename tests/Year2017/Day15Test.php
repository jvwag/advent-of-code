<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2017\Day15;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day15Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day15::class;

    public function testDay15(): void
    {
        $assignment = new Day15();
        $assignment->setInput(
            "Generator A starts with 65\n" .
            "Generator B starts with 8921\n"
        );
        $output = $assignment->run();

        self::assertEquals(588, $output[0]);
        self::assertEquals(309, $output[1]);
    }
}
