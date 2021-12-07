<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2021;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2021\Day7;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2021
 */
class Day7Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day7::class;

    public function testDay7(): void
    {
        $assignment = new Day7();
        $assignment->setInput("16,1,2,0,4,2,7,1,2,14\n");
        $output = $assignment->run();

        self::assertEquals(37, $output[0]);
        self::assertEquals(168, $output[1]);
    }
}
