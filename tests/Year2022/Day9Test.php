<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2022;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2022\Day9;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2022
 */
class Day9Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day9::class;

    public function testDay9(): void
    {
        $assignment = new Day9();
        $assignment->setInput("R 4\nU 4\nL 3\nD 1\nR 4\nD 1\nL 5\nR 2\n");
        $output = $assignment->run();

        self::assertEquals(13, $output[0]);
        self::assertEquals(1, $output[1]);
    }

    public function testDay9b(): void
    {
        $assignment = new Day9();
        $assignment->setInput("R 5\nU 8\nL 8\nD 3\nR 17\nD 10\nL 25\nU 20\n");
        $output = $assignment->run();

        self::assertEquals(36, $output[1]);
    }
}
