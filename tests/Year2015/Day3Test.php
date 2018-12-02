<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2015;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2015\Day3;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2015
 */
class Day3Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day3::class;

    /**
     * @dataProvider part1DataProvider
     *
     * @param $input
     * @param $expected
     */
    public function testDay3Part1($input, $expected): void
    {
        $assignment = new Day3();
        $assignment->setInput($input);
        $output = $assignment->run();

        self::assertEquals($expected, $output[0], "Route: ".$input);
    }

    /**
     * @return array
     */
    public function part1DataProvider(): array
    {
        return
            [
                [">", 2],
                ["^>v<", 4],
                ["^v^v^v^v^v", 2],
            ];
    }
}
