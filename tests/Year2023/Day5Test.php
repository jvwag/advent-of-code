<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2023;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2023\Day5;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2023
 */
class Day5Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day5::class;

    public function testDayTemplate(): void
    {
        $assignment = new Day5();
        $assignment->setInput(
            "seeds: 79 14 55 13\n\n" .
            "seed-to-soil map:\n50 98 2\n52 50 48\n\n" .
            "soil-to-fertilizer map:\n0 15 37\n37 52 2\n39 0 15\n\n" .
            "fertilizer-to-water map:\n49 53 8\n0 11 42\n42 0 7\n57 7 4\n\n" .
            "water-to-light map:\n88 18 7\n18 25 70\n\n" .
            "light-to-temperature map:\n45 77 23\n81 45 19\n68 64 13\n\n" .
            "temperature-to-humidity map:\n0 69 1\n1 0 69\n\n" .
            "humidity-to-location map:\n60 56 37\n56 93 4\n");
        $output = $assignment->run();

        self::assertEquals(35, $output[0]);
        self::assertEquals(null, $output[1]);
    }
}
