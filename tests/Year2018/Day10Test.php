<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2018;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2018\Day10;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2018
 */
class Day10Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day10::class;

    public function testDay10(): void
    {
        $assignment = new Day10();
        $assignment->setInput(
            "position=< 9,  1> velocity=< 0,  2>\n" .
            "position=< 7,  0> velocity=<-1,  0>\n" .
            "position=< 3, -2> velocity=<-1,  1>\n" .
            "position=< 6, 10> velocity=<-2, -1>\n" .
            "position=< 2, -4> velocity=< 2,  2>\n" .
            "position=<-6, 10> velocity=< 2, -2>\n" .
            "position=< 1,  8> velocity=< 1, -1>\n" .
            "position=< 1,  7> velocity=< 1,  0>\n" .
            "position=<-3, 11> velocity=< 1, -2>\n" .
            "position=< 7,  6> velocity=<-1, -1>\n" .
            "position=<-2,  3> velocity=< 1,  0>\n" .
            "position=<-4,  3> velocity=< 2,  0>\n" .
            "position=<10, -3> velocity=<-1,  1>\n" .
            "position=< 5, 11> velocity=< 1, -2>\n" .
            "position=< 4,  7> velocity=< 0, -1>\n" .
            "position=< 8, -2> velocity=< 0,  1>\n" .
            "position=<15,  0> velocity=<-2,  0>\n" .
            "position=< 1,  6> velocity=< 1,  0>\n" .
            "position=< 8,  9> velocity=< 0, -1>\n" .
            "position=< 3,  3> velocity=<-1,  1>\n" .
            "position=< 0,  5> velocity=< 0, -1>\n" .
            "position=<-2,  2> velocity=< 2,  0>\n" .
            "position=< 5, -2> velocity=< 1,  2>\n" .
            "position=< 1,  4> velocity=< 2,  1>\n" .
            "position=<-2,  7> velocity=< 2, -2>\n" .
            "position=< 3,  6> velocity=<-1, -1>\n" .
            "position=< 5,  0> velocity=< 1,  0>\n" .
            "position=<-6,  0> velocity=< 2,  0>\n" .
            "position=< 5,  9> velocity=< 1, -2>\n" .
            "position=<14,  7> velocity=<-2,  0>\n" .
            "position=<-3,  6> velocity=< 2, -1>\n");
        $output = $assignment->run();

        self::assertEquals(
            "x   x  xxx" . PHP_EOL .
            "x   x   x " . PHP_EOL .
            "x   x   x " . PHP_EOL .
            "xxxxx   x " . PHP_EOL .
            "x   x   x " . PHP_EOL .
            "x   x   x " . PHP_EOL .
            "x   x   x " . PHP_EOL .
            "x   x  xxx" . PHP_EOL, $output[0]);
        self::assertEquals(2, $output[1]);
    }
}
