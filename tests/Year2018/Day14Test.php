<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2018;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2018\Day14;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2018
 */
class Day14Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day14::class;

    /**
     * @dataProvider dataProviderPart1
     * @param string $input
     * @param int $expected
     */
    public function testDay14Part1($input, $expected): void
    {
        $assignment = new Day14();
        $assignment->setInput($input);
        $output = $assignment->run();

        self::assertEquals($expected, $output[0]);
    }

    public function dataProviderPart1(): array
    {
        return
            [
                ["5\n", "0124515891"],
                ["9\n", "5158916779"],
                ["18\n", "9251071085"],
                ["2018\n", "5941429882"],
            ];
    }

    /**
     * @dataProvider dataProviderPart2
     * @param string $input
     * @param int $expected
     */
    public function testDay14Part2($input, $expected): void
    {
        $assignment = new Day14();
        $assignment->setInput($input);
        $output = $assignment->run();

        self::assertEquals($expected, $output[1]);
    }

    public function dataProviderPart2(): array
    {
        return
            [
                ["01245\n", 5],
                ["51589\n", 9],
                ["92510\n", 18],
                ["59414\n", 2018],
            ];
    }
}
