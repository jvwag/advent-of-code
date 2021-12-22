<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2021;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2021\Day21;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2021
 */
class Day21Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day21::class;

    public function testDay21(): void
    {
        $assignment = new Day21();
        $assignment->setInput("Player 1 starting position: 4\nPlayer 2 starting position: 8\n");
        $output = $assignment->run();

        self::assertEquals(739785, $output[0]);
        self::assertEquals(444356092776315, $output[1]);
    }
}
