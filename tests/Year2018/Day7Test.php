<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2018;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2018\Day7;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2018
 */
class Day7Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day7::class;

    public function testDay7(): void
    {
        $assignment = new Day7();
        $assignment->setInput(
            "Step C must be finished before step A can begin.\n" .
            "Step C must be finished before step F can begin.\n" .
            "Step A must be finished before step B can begin.\n" .
            "Step A must be finished before step D can begin.\n" .
            "Step B must be finished before step E can begin.\n" .
            "Step D must be finished before step E can begin.\n" .
            "Step F must be finished before step E can begin.\n"
        );
        $assignment->setBaseTime(0);
        $assignment->setMaxJobs(2);
        $output = $assignment->run();

        self::assertEquals("CABDFE", $output[0]);
        self::assertEquals(15, $output[1]);
    }
}
