<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2022;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2022\Day11;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2022
 */
class Day11Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day11::class;

    public function testDay11(): void
    {
        $assignment = new Day11();
        $assignment->setInput(
            "Monkey 0:\n" .
            "  Starting items: 79, 98\n" .
            "  Operation: new = old * 19\n" .
            "  Test: divisible by 23\n" .
            "    If true: throw to monkey 2\n" .
            "    If false: throw to monkey 3\n" .
            "\n" .
            "Monkey 1:\n" .
            "  Starting items: 54, 65, 75, 74\n" .
            "  Operation: new = old + 6\n" .
            "  Test: divisible by 19\n" .
            "    If true: throw to monkey 2\n" .
            "    If false: throw to monkey 0\n" .
            "\n" .
            "Monkey 2:\n" .
            "  Starting items: 79, 60, 97\n" .
            "  Operation: new = old * old\n" .
            "  Test: divisible by 13\n" .
            "    If true: throw to monkey 1\n" .
            "    If false: throw to monkey 3\n" .
            "\n" .
            "Monkey 3:\n" .
            "  Starting items: 74\n" .
            "  Operation: new = old + 3\n" .
            "  Test: divisible by 17\n" .
            "    If true: throw to monkey 0\n" .
            "    If false: throw to monkey 1\n"
        );
        $output = $assignment->run();

        self::assertEquals(10605, $output[0]);
        self::assertEquals(2713310158, $output[1]);
    }
}
