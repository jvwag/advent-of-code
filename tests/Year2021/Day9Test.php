<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2021;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2021\Day9;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2021
 */
class Day9Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day9::class;

    public function testDay9(): void
    {
        $assignment = new Day9();
        $assignment->setInput("2199943210\n3987894921\n9856789892\n8767896789\n9899965678\n");
        $output = $assignment->run();

        self::assertEquals(15, $output[0]);
        self::assertEquals(1134, $output[1]);
    }
}
