<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2015;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2015\Day12;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2015
 */
class Day12Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day12::class;

    /**
     * @dataProvider dataProvider
     * @param $expected
     * @param $input
     */
    public function testDay12($input, $expected): void
    {
        $assignment = new Day12();

        self::assertSame($expected, $assignment->countArray(json_decode($input, true)));
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return
            [
                ['[1,2,3]', 6],
                ['{"a":2,"b":4}', 6],
                ['[[[3]]]', 3],
                ['{"a":{"b":4},"c":-1}', 3],
                ['{"a":[-1,1]}', 0],
                ['[-1,{"a":1}]', 0],
                ['[]', 0],
                ['{}', 0],
            ];
    }
}
