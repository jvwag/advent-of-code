<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2017\Day20;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day20Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day20::class;

    public function testDay20Part1()
    {
        $assignment = new Day20();
        $input =
            "p=<3,0,0>, v=<2,0,0>, a=<-1,0,0>\n" .
            "p=<4,0,0>, v=<0,0,0>, a=<-2,0,0>\n";

        $output = $assignment->run1($input);

        self::assertSame(0, $output);
    }

    public function testDay20Part2()
    {
        $assignment = new Day20();
        $input =
            "p=<-6,0,0>, v=<3,0,0>, a=<0,0,0>\n" .
            "p=<-4,0,0>, v=<2,0,0>, a=<0,0,0>\n" .
            "p=<-2,0,0>, v=<1,0,0>, a=<0,0,0>\n" .
            "p=<3,0,0>, v=<-1,0,0>, a=<0,0,0>\n";

        $output = $assignment->run2($input);

        self::assertSame(1, $output);
    }
}
