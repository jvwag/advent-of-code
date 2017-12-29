<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2017\Day14;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day14Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day14::class;

    public function testDay14()
    {
        $assignment = new Day14();
        $assignment->setInput("flqrgnkx");
        $output = $assignment->run();

        self::assertEquals(8108, $output[0]);
        self::assertEquals(1242, $output[1]);
    }

    /**
     * @dataProvider providerDay14FindAround
     * @param int $x Location
     * @param int $size Size
     * @param array $expected Expected coordinates
     */
    public function testDay14FindAround($x, $size, $expected) {
        $assignment = new Day14();
        self::assertEquals($expected, $assignment->findAround($x, $size), $x);
    }

    /**
     * @return array
     */
    public function providerDay14FindAround(): array
    {
        return
            [
                [0, 5, [1, 5]],
                [1, 5, [0, 2, 6]],
                [4, 5, [3, 9]],
                [5, 5, [0, 6, 10]],
                [9, 5, [4, 8, 14]],
                [20, 5, [15, 21]],
                [21, 5, [16, 20, 22]],
                [24, 5, [19, 23]],
            ];
    }
}
