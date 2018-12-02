<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2018;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2018\Day2;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2018
 */
class Day2Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day2::class;

    public function testDay2Part1(): void
    {
        $assignment = new Day2();
        $assignment->setInput("abcdef\nbababc\nabbcde\nabcccd\naabcdd\nabcdee\nababab\n");
        $output = $assignment->run();

        self::assertEquals(12, $output[0]);
    }

    public function testDay2Part2(): void
    {
        $assignment = new Day2();
        $assignment->setInput("abcde\nfghij\nklmno\npqrst\nfguij\naxcye\nwvxyz\n");
        $output = $assignment->run();

        self::assertEquals("fgij", $output[1]);
    }
}
