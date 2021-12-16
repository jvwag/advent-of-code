<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2021;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2021\Day16;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2021
 */
class Day16Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day16::class;

    /**
     * @dataProvider providerDay16Part1
     * @param $input
     * @param $expected
     * @return void
     */
    public function testDay16Part1($input, $expected): void
    {
        $assignment = new Day16();
        $binary_string = $assignment->convertHexStringToBinaryString($input);
        $packets = $assignment->parsePackets($binary_string);

        self::assertEquals($expected, $assignment->sumVersions($packets));
    }

    public function providerDay16Part1(): array
    {
        return
            [
                ["D2FE28", 6],
                ["8A004A801A8002F478", 16],
                ["620080001611562C8802118E34", 12],
                ["C0015000016115A2E0802F182340", 23],
                ["A0016C880162017C3686B18A3D4780", 31]
            ];
    }

    /**
     * @dataProvider providerDay16Part2
     * @param $input
     * @param $expected
     * @return void
     */
    public function testDay16Part2($input, $expected): void
    {
        $assignment = new Day16();
        $binary_string = $assignment->convertHexStringToBinaryString($input);
        $packets = $assignment->parsePackets($binary_string);

        self::assertEquals($expected, $assignment->solveExpression($packets[0]));
    }

    public function providerDay16Part2(): array
    {
        return
            [
                ["C200B40A82", 3],
                ["04005AC33890", 54],
                ["880086C3E88112", 7],
                ["CE00C43D881120", 9],
                ["D8005AC2A8F0", 1],
                ["F600BC2D8F", 0],
                ["9C005AC2F8F0", 0],
                ["9C0141080250320F1802104A08", 1],
            ];
    }
}
