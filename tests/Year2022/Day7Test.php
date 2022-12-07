<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2022;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2022\Day7;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2022
 */
class Day7Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day7::class;

    public function testDay7(): void
    {
        $assignment = new Day7();
        $assignment->setInput(
            "$ cd /\n" .
            "$ ls\n" .
            "dir a\n" .
            "14848514 b.txt\n" .
            "8504156 c.dat\n" .
            "dir d\n" .
            "$ cd a\n" .
            "$ ls\n" .
            "dir e\n" .
            "29116 f\n" .
            "2557 g\n" .
            "62596 h.lst\n" .
            "$ cd e\n" .
            "$ ls\n" .
            "584 i\n" .
            "$ cd ..\n" .
            "$ cd ..\n" .
            "$ cd d\n" .
            "$ ls\n" .
            "4060174 j\n" .
            "8033020 d.log\n" .
            "5626152 d.ext\n" .
            "7214296 k\n"
        );
        $output = $assignment->run();

        self::assertEquals(95437, $output[0]);
        self::assertEquals(24933642, $output[1]);
    }
}
