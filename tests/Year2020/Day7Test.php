<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2020;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2020\Day7;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2019
 */
class Day7Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day7::class;

    public function testDay7(): void
    {
        $assignment = new Day7();
        $assignment->setInput("light red bags contain 1 bright white bag, 2 muted yellow bags.\n" .
            "dark orange bags contain 3 bright white bags, 4 muted yellow bags.\n" .
            "bright white bags contain 1 shiny gold bag.\n" .
            "muted yellow bags contain 2 shiny gold bags, 9 faded blue bags.\n" .
            "shiny gold bags contain 1 dark olive bag, 2 vibrant plum bags.\n" .
            "dark olive bags contain 3 faded blue bags, 4 dotted black bags.\n" .
            "vibrant plum bags contain 5 faded blue bags, 6 dotted black bags.\n" .
            "faded blue bags contain no other bags.\n" .
            "dotted black bags contain no other bags.\n");
        $output = $assignment->run();

        self::assertEquals(4, $output[0]);
        self::assertEquals(32, $output[1]);
    }
}
