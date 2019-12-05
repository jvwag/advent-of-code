<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2019;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2019\Day5;
use RuntimeException;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2019
 */
class Day5Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day5::class;

    public function testDay5InvalidOpcode(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Invalid instruction 55 on pos 0");

        $assignment = new Day5();
        $assignment->process([55], 0);
    }

    public function testDay5InvalidParameter1(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Invalid mode for parameter 1");

        $assignment = new Day5();
        $assignment->process([201], 0);
    }

    public function testDay5InvalidParameter2(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Invalid mode for parameter 2");

        $assignment = new Day5();
        $assignment->process([2101], 0);
    }

    public function testDay5Part2Examples(): void
    {
        $assignment = new Day5();
        self::assertSame(0, $assignment->process([3,9,8,9,10,9,4,9,99,-1,8], 7));
        self::assertSame(1, $assignment->process([3,9,8,9,10,9,4,9,99,-1,8], 8));
        self::assertSame(0, $assignment->process([3,9,8,9,10,9,4,9,99,-1,8], 9));

        self::assertSame(1, $assignment->process([3,9,7,9,10,9,4,9,99,-1,8], 6));
        self::assertSame(1, $assignment->process([3,9,7,9,10,9,4,9,99,-1,8], 7));
        self::assertSame(0, $assignment->process([3,9,7,9,10,9,4,9,99,-1,8], 8));
        self::assertSame(0, $assignment->process([3,9,7,9,10,9,4,9,99,-1,8], 9));

        self::assertSame(0, $assignment->process([3,3,1108,-1,8,3,4,3,99], 7));
        self::assertSame(1, $assignment->process([3,3,1108,-1,8,3,4,3,99], 8));
        self::assertSame(0, $assignment->process([3,3,1108,-1,8,3,4,3,99], 9));

        self::assertSame(1, $assignment->process([3,3,1107,-1,8,3,4,3,99], 6));
        self::assertSame(1, $assignment->process([3,3,1107,-1,8,3,4,3,99], 7));
        self::assertSame(0, $assignment->process([3,3,1107,-1,8,3,4,3,99], 8));
        self::assertSame(0, $assignment->process([3,3,1107,-1,8,3,4,3,99], 9));
    }

    /**
     * @dataProvider part2DataProvider
     * @param int $input
     * @param int $expected
     */
    public function testDay5Part2LargeExample($input, $expected): void
    {
        $assignment = new Day5();
        $output = $assignment->process([3, 21, 1008, 21, 8, 20, 1005, 20, 22, 107, 8, 21, 20, 1006, 20, 31,
            1106, 0, 36, 98, 0, 0, 1002, 21, 125, 20, 4, 20, 1105, 1, 46, 104,
            999, 1105, 1, 46, 1101, 1000, 1, 20, 4, 20, 1105, 1, 46, 98, 99], $input);

        self::assertSame($expected, $output);
    }

    /**
     * @return array
     */
    public function part2DataProvider(): array
    {
        return
            [
                [7, 999],
                [8, 1000],
                [9, 1001],
            ];
    }
}
