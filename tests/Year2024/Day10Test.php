<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2024;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2024\Day10;

class Day10Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day10::class;

    public function testDay10(): void
    {
        $assignment = new Day10();
        $assignment->setInput("89010123\n78121874\n87430965\n96549874\n45678903\n32019012\n01329801\n10456732\n");
        $output = $assignment->run();

        self::assertEquals(36, $output[0]);
        self::assertEquals(81, $output[1]);
    }
}
