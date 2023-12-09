<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2023;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2023\Day9;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2023
 */
class Day9Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day9::class;

    public function testDay9(): void
    {
        $assignment = new Day9();
        $assignment->setInput("0 3 6 9 12 15\n1 3 6 10 15 21\n10 13 16 21 30 45\n");
        $output = $assignment->run();

        self::assertEquals(114, $output[0]);
        self::assertEquals(2, $output[1]);
    }
}
