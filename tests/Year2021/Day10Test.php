<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2021;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2021\Day10;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2021
 */
class Day10Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day10::class;

    public function testDay10(): void
    {
        $assignment = new Day10();
        $assignment->setInput(
            "[({(<(())[]>[[{[]{<()<>>\n" .
            "[(()[<>])]({[<{<<[]>>(\n" .
            "{([(<{}[<>[]}>{[]{[(<()>\n" .
            "(((({<>}<{<{<>}{[]{[]{}\n" .
            "[[<[([]))<([[{}[[()]]]\n" .
            "[{[{({}]{}}([{[{{{}}([]\n" .
            "{<[[]]>}<{[{[{[]{()[[[]\n" .
            "[<(<(<(<{}))><([]([]()\n" .
            "<{([([[(<>()){}]>(<<{{\n" .
            "<{([{{}}[<[[[<>{}]]]>[]]\n"
        );
        $output = $assignment->run();

        self::assertEquals(26397, $output[0]);
        self::assertEquals(288957, $output[1]);
    }
}
