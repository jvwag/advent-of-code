<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2019;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2019\Day5;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2019
 */
class Day5Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day5::class;

    /**
     * @dataProvider providerDay5LargeExample
     * @param int $input
     * @param int $expected
     */
    public function testDay5LargeExample(int $input, int $expected): void
    {
        $assignment = new Day5();
        $result = $assignment->solve([3, 21, 1008, 21, 8, 20, 1005, 20, 22, 107, 8, 21, 20, 1006, 20, 31,
            1106, 0, 36, 98, 0, 0, 1002, 21, 125, 20, 4, 20, 1105, 1, 46, 104,
            999, 1105, 1, 46, 1101, 1000, 1, 20, 4, 20, 1105, 1, 46, 98, 99], $input);

        self::assertSame($expected, $result);
    }

    /**
     * @return array[]
     */
    public function providerDay5LargeExample(): array
    {
        return
            [
                [7, 999],
                [8, 1000],
                [9, 1001],
            ];
    }
}
