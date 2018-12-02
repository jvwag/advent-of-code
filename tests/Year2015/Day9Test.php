<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2015;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2015\Day9;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2015
 */
class Day9Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day9::class;

    public function testDay9Example(): void
    {
        $assignment = new Day9();
        $assignment->setInput(
            "London to Dublin = 464\n" .
            "London to Belfast = 518\n" .
            "Dublin to Belfast = 141\n"
        );
        $output = $assignment->run();

        self::assertEquals(605, $output[0]);
        self::assertEquals(982, $output[1]);
    }
}
