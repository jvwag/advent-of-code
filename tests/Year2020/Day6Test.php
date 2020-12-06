<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2020;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2020\Day6;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2019
 */
class Day6Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day6::class;

    public function testDay6(): void
    {
        $assignment = new Day6();
        $assignment->setInput("abc\n\na\nb\nc\n\nab\nac\n\na\na\na\na\n\nb\n");
        $output = $assignment->run();

        self::assertEquals(11, $output[0]);
        self::assertEquals(6, $output[1]);
    }
}
