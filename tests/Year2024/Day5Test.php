<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2024;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2024\Day5;

class Day5Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day5::class;

    public function testDayTemplate(): void
    {
        $assignment = new Day5();
        $assignment->setInput(
            "47|53\n97|13\n97|61\n97|47\n75|29\n61|13\n75|53\n29|13\n97|29\n53|29\n61|53\n" .
            "97|53\n61|29\n47|13\n75|47\n97|75\n47|61\n75|61\n47|29\n75|13\n53|13\n\n" .
            "75,47,61,53,29\n97,61,53,29,13\n75,29,13\n75,97,47,61,53\n61,13,29\n97,13,75,29,47\n");
        $output = $assignment->run();

        self::assertEquals(143, $output[0]);
        self::assertEquals(123, $output[1]);
    }
}
