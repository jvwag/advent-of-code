<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2018;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2018\Day5;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2018
 */
class Day5Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day5::class;

    public function testDay5(): void
    {
        $assignment = new Day5();
        $assignment->setInput("dabAcCaCBAcCcaDA");
        $output = $assignment->run();

        self::assertEquals(10, $output[0]);
        self::assertEquals(4, $output[1]);
    }
}
