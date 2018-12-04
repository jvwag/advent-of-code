<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2018;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2018\Day4;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2018
 */
class Day4Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day4::class;

    public function testDay4(): void
    {
        $assignment = new Day4();
        $assignment->setInput(
            "[1518-11-01 00:00] Guard #10 begins shift\n" .
            "[1518-11-01 00:05] falls asleep\n" .
            "[1518-11-01 00:25] wakes up\n" .
            "[1518-11-01 00:30] falls asleep\n" .
            "[1518-11-01 00:55] wakes up\n" .
            "[1518-11-01 23:58] Guard #99 begins shift\n" .
            "[1518-11-02 00:40] falls asleep\n" .
            "[1518-11-02 00:50] wakes up\n" .
            "[1518-11-03 00:05] Guard #10 begins shift\n" .
            "[1518-11-03 00:24] falls asleep\n" .
            "[1518-11-03 00:29] wakes up\n" .
            "[1518-11-04 00:02] Guard #99 begins shift\n" .
            "[1518-11-04 00:36] falls asleep\n" .
            "[1518-11-04 00:46] wakes up\n" .
            "[1518-11-05 00:03] Guard #99 begins shift\n" .
            "[1518-11-05 00:45] falls asleep\n" .
            "[1518-11-05 00:55] wakes up\n");
        $output = $assignment->run();

        self::assertEquals(240, $output[0]);
        self::assertEquals(4455, $output[1]);
    }
}
