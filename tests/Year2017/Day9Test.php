<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2017\Day9;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day9Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day9::class;

    /**
     * @param string $input Input to clean
     * @param string $expected Expected output
     * @dataProvider providerCleanCancels
     */
    public function testDay9CleanCancels($input, $expected)
    {
        $assignment = new Day9();

        $output = $assignment->cleanCancels($input);
        self::assertSame($expected, $output);
    }

    /**
     * @return array
     */
    public function providerCleanCancels(): array
    {
        return
            [
                ['<>', '<>'],
                ['<random characters>', '<random characters>'],
                ['<<<<>', '<<<<>'],
                ['<{!>}>', '<{}>'],
                ['<!!>', '<>'],
                ['<!!!>>', '<>'],
                ['<{o"i,<{i<a>', '<{o"i,<{i<a>'],
                ['!x', ''],
                ['!xyz', 'yz'],
                ['xyz', 'xyz'],
            ];
    }

    /**
     * @param string $input Input to clean
     * @param string $expected_output Expected output
     * @param int $expected_remove_chars Expected number of chars that were removed by the cleaning
     * @dataProvider providerCleanGarbage
     */
    public function testDay9CleanGarbage($input, $expected_output, $expected_remove_chars)
    {
        $assignment = new Day9();

        $output = $assignment->cleanCancels($input);
        $output = $assignment->cleanGarbage($output, $removed_chars);
        self::assertSame($expected_output, $output);
        self::assertSame($expected_remove_chars, $removed_chars);
    }

    /**
     * @return array
     */
    public function providerCleanGarbage(): array
    {
        return
            [
                ['<>', '', 0],
                ['<random characters>', '', 17],
                ['<<<<>', '', 3],
                ['<{!>}>', '', 2],
                ['<!!>', '', 0],
                ['<!!!>>', '', 0],
                ['<{o"i,<{i<a>', '', 10],
                ['x<{o"i,<{i<a>', 'x', 10],
                ['xy<<<<>', 'xy', 3],
                ['x<>y<>z', 'xyz', 0],
            ];
    }

    /**
     * @param string $input Input with group markers
     * @param int $expected Expected weighed number of groups
     * @dataProvider providerCountGroups
     */
    public function testDay9CountGroups($input, $expected)
    {
        $assignment = new Day9();
        $output = $assignment->cleanCancels($input);
        $output = $assignment->cleanGarbage($output);
        $output = $assignment->weighGroups($output);
        self::assertSame($expected, $output);
    }

    /**
     * @return array
     */
    public function providerCountGroups(): array
    {
        return
            [
                ["{}", 1],
                ["{{{}}}", 6],
                ["{{},{}}", 5],
                ["{{{},{},{{}}}}", 16],
                ["{<a>,<a>,<a>,<a>}", 1],
                ["{{<ab>},{<ab>},{<ab>},{<ab>}}", 9],
                ["{{<!!>},{<!!>},{<!!>},{<!!>}}", 9],
                ["{{<a!>},{<a!>},{<a!>},{<ab>}}", 3],
            ];
    }
}
