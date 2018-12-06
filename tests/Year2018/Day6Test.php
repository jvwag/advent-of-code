<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2018;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2018\Day6;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2018
 */
class Day6Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day6::class;

    public function testDay6(): void
    {
        $assignment = new Day6();
        $assignment->setInput("1, 1\n1, 6\n8, 3\n3, 4\n5, 5\n8, 9\n");
        $assignment->setMaxDistance(32);
        $output = $assignment->run();

        self::assertEquals(17, $output[0]);
        self::assertEquals(16, $output[1]);
    }
}
