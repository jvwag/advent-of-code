<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2020;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2020\Day15;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2019
 */
class Day15Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day15::class;

    /**
     * @dataProvider day15DataProvider()
     * @param int $expected1
     * @param int $expected2
     * @param string $input
     */
    public function testDay15(int $expected1, int $expected2, string $input): void
    {
        $assignment = new Day15();
        $assignment->setInput($input);
        $output = $assignment->run();

        self::assertEquals($expected1, $output[0]);
        self::assertEquals($expected2, $output[1]);

    }

    public function day15DataProvider(): array
    {
        return
            [
                [436, 175594, "0,3,6\n"],
                [1, 2578, "1,3,2\n"],
                [10, 3544142, "2,1,3\n"],
                [27, 261214, "1,2,3\n"],
                [78, 6895259, "2,3,1\n"],
                [438, 18, "3,2,1\n"],
                [1836, 362, "3,1,2\n"],
            ];
    }
}
