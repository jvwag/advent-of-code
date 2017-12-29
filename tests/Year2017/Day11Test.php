<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2017\Day11;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day11Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day11::class;

    /**
     * @param string $input Input
     * @param int $expected1 Expected distance
     * @param int $expected2 Expected maximum distance
     * @dataProvider providerDay11
     */
    public function testDay11($input, $expected1, $expected2)
    {
        $assignment = new Day11();
        $assignment->setInput($input);
        $output = $assignment->run();

        self::assertEquals($expected1, $output[0]);
        self::assertEquals($expected2, $output[1]);
    }

    /**
     * @return array
     */
    public function providerDay11(): array
    {
        return
            [
                ["ne,ne,ne", 3, 3],
                ["ne,ne,sw,sw", 0, 2],
                ["ne,ne,s,s", 2, 2],
                ["se,sw,se,sw,sw", 3, 3],
            ];
    }
}
