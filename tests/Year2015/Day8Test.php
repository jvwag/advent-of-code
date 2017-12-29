<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2015;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2015\Day8;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2015
 */
class Day8Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day8::class;

    public function testDay8Example()
    {
        $assignment = new Day8();
        $assignment->setInput(
            '""' . "\n" .
            '"abc"' . "\n" .
            '"aaa\"aaa"' . "\n" .
            '"\x27"' . "\n"
        );
        $output = $assignment->run();

        self::assertEquals(12, $output[0]);
        self::assertEquals(19, $output[1]);
    }
}
