<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2019;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2019\Day8;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2019
 */
class Day8Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day8::class;

    public function testDay8(): void
    {
        $assignment = new Day8();
        $output = $assignment->run2(["0222", "1122", "2212", "0000"], 2);

        self::assertEquals(" \u{2588}".PHP_EOL."\u{2588}", $output);
    }
}
