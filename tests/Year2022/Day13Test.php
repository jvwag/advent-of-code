<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2022;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2022\Day13;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2022
 */
class Day13Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day13::class;

    public function testDay13(): void
    {
        $assignment = new Day13();
        $assignment->setInput(
            "[1,1,3,1,1]\n" .
            "[1,1,5,1,1]\n\n" .
            "[[1],[2,3,4]]\n" .
            "[[1],4]\n\n" .
            "[9]\n" .
            "[[8,7,6]]\n\n" .
            "[[4,4],4,4]\n" .
            "[[4,4],4,4,4]\n\n" .
            "[7,7,7,7]\n" .
            "[7,7,7]\n\n" .
            "[]\n" .
            "[3]\n\n" .
            "[[[]]]\n" .
            "[[]]\n\n" .
            "[1,[2,[3,[4,[5,6,7]]]],8,9]\n" .
            "[1,[2,[3,[4,[5,6,0]]]],8,9]\n");
        $output = $assignment->run();

        self::assertEquals(13, $output[0]);
        self::assertEquals(140, $output[1]);
    }
}
