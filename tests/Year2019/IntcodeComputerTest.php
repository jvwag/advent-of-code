<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2019;

use jvwag\AdventOfCode\Year2019\IntcodeComputer;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2019
 */
class IntcodeComputerTest extends TestCase
{
    public function testIntcodeComputerDay2InvalidOpcode(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Invalid instruction 55 on pos 0");

        $ic = new IntcodeComputer([55]);
        $ic->runToEnd();
    }

    /**
     * @dataProvider providerIntcodeComputerDay2Examples
     * @param int[] $program
     * @param int[] $expected_program
     */
    public function testIntcodeComputerDay2Examples(array $program, array $expected_program): void
    {
        $ic = new IntcodeComputer($program);
        $ic->process()->current();

        self::assertSame($expected_program, $ic->getProgram());
    }

    public function providerIntcodeComputerDay2Examples(): array
    {
        return
            [
                [[1, 9, 10, 3, 2, 3, 11, 0, 99, 30, 40, 50], [3500, 9, 10, 70, 2, 3, 11, 0, 99, 30, 40, 50]],
                [[1, 0, 0, 0, 99], [2, 0, 0, 0, 99]],
                [[2, 3, 0, 3, 99], [2, 3, 0, 6, 99]],
                [[2, 4, 4, 5, 99, 0], [2, 4, 4, 5, 99, 9801]],
                [[1, 1, 1, 4, 99, 5, 6, 0, 99], [30, 1, 1, 4, 2, 5, 6, 0, 99]]
            ];
    }

    public function testIntcodeComputerDay5InvalidParameter1(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Invalid mode for parameter 1");

        $ic = new IntcodeComputer([201]);
        $ic->runToEnd();
    }

    public function testIntcodeComputerDay5InvalidParameter2(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Invalid mode for parameter 2");

        $ic = new IntcodeComputer([2101]);
        $ic->runToEnd();
    }

    /**
     * @dataProvider providerIntcodeComputerDay5Examples
     * @param int[] $program
     * @param int[] $input
     * @param int $expected_output
     */
    public function testIntcodeComputerDay5Examples(array $program, array $input, int $expected_output): void
    {
        $ic = new IntcodeComputer($program, $input);
        self::assertSame($expected_output, $ic->runToFirstOutput());
    }

    public function providerIntcodeComputerDay5Examples(): array
    {
        return
            [
                [[3, 9, 8, 9, 10, 9, 4, 9, 99, -1, 8], [7], 0],
                [[3, 9, 8, 9, 10, 9, 4, 9, 99, -1, 8], [8], 1],
                [[3, 9, 8, 9, 10, 9, 4, 9, 99, -1, 8], [9], 0],

                [[3, 9, 7, 9, 10, 9, 4, 9, 99, -1, 8], [6], 1],
                [[3, 9, 7, 9, 10, 9, 4, 9, 99, -1, 8], [7], 1],
                [[3, 9, 7, 9, 10, 9, 4, 9, 99, -1, 8], [8], 0],
                [[3, 9, 7, 9, 10, 9, 4, 9, 99, -1, 8], [9], 0],

                [[3, 3, 1108, -1, 8, 3, 4, 3, 99], [7], 0],
                [[3, 3, 1108, -1, 8, 3, 4, 3, 99], [8], 1],
                [[3, 3, 1108, -1, 8, 3, 4, 3, 99], [9], 0],

                [[3, 3, 1107, -1, 8, 3, 4, 3, 99], [6], 1],
                [[3, 3, 1107, -1, 8, 3, 4, 3, 99], [7], 1],
                [[3, 3, 1107, -1, 8, 3, 4, 3, 99], [8], 0],
                [[3, 3, 1107, -1, 8, 3, 4, 3, 99], [9], 0],
            ];
    }
}
