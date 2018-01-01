<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2017\Day25;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day25Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day25::class;

    public function testDay25()
    {
        $assignment = new Day25();
        $assignment->setInput(
            "Begin in state A.\n" .
            "Perform a diagnostic checksum after 6 steps.\n" .
            "\n" .
            "In state A:\n" .
            "  If the current value is 0:\n" .
            "    - Write the value 1.\n" .
            "    - Move one slot to the right.\n" .
            "    - Continue with state B.\n" .
            "  If the current value is 1:\n" .
            "    - Write the value 0.\n" .
            "    - Move one slot to the left.\n" .
            "    - Continue with state B.\n" .
            "\n" .
            "In state B:\n" .
            "  If the current value is 0:\n" .
            "    - Write the value 1.\n" .
            "    - Move one slot to the left.\n" .
            "    - Continue with state A.\n" .
            "  If the current value is 1:\n" .
            "    - Write the value 1.\n" .
            "    - Move one slot to the right.\n" .
            "    - Continue with state A.\n"
        );
        $output = $assignment->run();

        self::assertEquals(3, $output[0]);
        self::assertEquals(null, $output[1]);
    }
}
