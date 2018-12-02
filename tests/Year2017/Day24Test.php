<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2017\Day24;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day24Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day24::class;

    public function testDay24(): void
    {
        $assignment = new Day24();
        $assignment->setInput("0/2\n2/2\n2/3\n3/4\n3/5\n0/1\n10/1\n9/10\n");
        $output = $assignment->run();

        self::assertEquals(31, $output[0]);
        self::assertEquals(19, $output[1]);
    }
}
