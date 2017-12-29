<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2015;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2015\Day2;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2015
 */
class Day2Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day2::class;

    public function testDay2()
    {
        $assignment = new Day2();
        $assignment->setInput("2x3x4\n1x1x10\n");
        $output = $assignment->run();

        self::assertEquals(58 + 43, $output[0]);
        self::assertEquals(34 + 14, $output[1]);
    }
}
