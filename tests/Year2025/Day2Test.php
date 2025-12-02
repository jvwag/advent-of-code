<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2025;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2025\Day2;

class Day2Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day2::class;

    public function testDay2(): void
    {
        $assignment = new Day2();
        $assignment->setInput("11-22,95-115,998-1012,1188511880-1188511890,222220-222224,1698522-1698528,446443-446449,38593856-38593862,565653-565659,824824821-824824827,2121212118-2121212124");
        $output = $assignment->run();

        self::assertEquals(1227775554, $output[0]);
        self::assertEquals(4174379265, $output[1]);
    }
}
