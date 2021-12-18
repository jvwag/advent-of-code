<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2021;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2021\Day18;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2021
 */
class Day18Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day18::class;

    public function testDay18(): void
    {
        $assignment = new Day18();
        $assignment->setInput("");
        $output = $assignment->run();

        self::assertEquals(null, $output[0]);
        self::assertEquals(null, $output[1]);
    }

    /**
     * @dataProvider providerExplodeOneStep()
     */
    public function testExplodeOneStep($input, $expected)
    {
        $assignment = new Day18();
        $output = $assignment->explode($input);
        self::assertEquals($expected, $output);
    }

    public function providerExplodeOneStep(): array
    {
        return [
            ["[[[[[[1,2],[10,4]]]]]]", "[[[[[0,[12,4]]]]]]"],
            ["[[[[[[1,2],[3,4]]]]]]", "[[[[[0,[5,4]]]]]]"],
            ["[[[[[9,8],1],2],3],4]", "[[[[0,9],2],3],4]"],
            ["[[[[[9,8],2],2],3],4]", "[[[[0,10],2],3],4]"],
            ["[7,[6,[5,[4,[3,2]]]]]", "[7,[6,[5,[7,0]]]]"],
            ["[[6,[5,[4,[3,2]]]],1]", "[[6,[5,[7,0]]],3]"],
            ["[[3,[2,[1,[7,3]]]],[6,[5,[4,[3,2]]]]]", "[[3,[2,[8,0]]],[9,[5,[4,[3,2]]]]]"],
            ["[[3,[2,[8,0]]],[9,[5,[4,[3,2]]]]]", "[[3,[2,[8,0]]],[9,[5,[7,0]]]]"],
        ];
    }

    /**
     * @dataProvider providerSplitOneStep()
     */
    public function testSplitOneStep($input, $expected)
    {
        $assignment = new Day18();
        $output = $assignment->split($input);
        self::assertEquals($expected, $output);
    }

    public function providerSplitOneStep(): array
    {
        return [
            ["[[[[0,7],4],[15,[0,13]]],[1,1]]", "[[[[0,7],4],[[7,8],[0,13]]],[1,1]]"],
            ["[[[[0,7],4],[[7,8],[0,13]]],[1,1]]", "[[[[0,7],4],[[7,8],[0,[6,7]]]],[1,1]]"],
        ];
    }

    /**
     * @dataProvider providerAddition()
     */
    public function testAdditionAndReduce($input, $expected)
    {
        $assignment = new Day18();
        $output = $assignment->add_and_reduce($input);
        self::assertEquals($expected, $output);
    }

    public function providerAddition(): array
    {
        return [
            [["[1,1]", "[2,2]", "[3,3]", "[4,4]"], "[[[[1,1],[2,2]],[3,3]],[4,4]]"],
            [["[1,1]", "[2,2]", "[3,3]", "[4,4]", "[5,5]"], "[[[[3,0],[5,3]],[4,4]],[5,5]]"],
            [["[1,1]", "[2,2]", "[3,3]", "[4,4]", "[5,5]", "[6,6]"], "[[[[5,0],[7,4]],[5,5]],[6,6]]"],
            [
                [
                    "[[[0,[4,5]],[0,0]],[[[4,5],[2,6]],[9,5]]]",
                    "[7,[[[3,7],[4,3]],[[6,3],[8,8]]]]",
                    "[[2,[[0,8],[3,4]]],[[[6,7],1],[7,[1,6]]]]",
                    "[[[[2,4],7],[6,[0,5]]],[[[6,8],[2,8]],[[2,1],[4,5]]]]",
                    "[7,[5,[[3,8],[1,4]]]]",
                    "[[2,[2,2]],[8,[8,1]]]",
                    "[2,9]",
                    "[1,[[[9,3],9],[[9,0],[0,7]]]]",
                    "[[[5,[7,4]],7],1]",
                    "[[[[4,2],2],6],[8,7]]"
                ],
                "[[[[8,7],[7,7]],[[8,6],[7,7]]],[[[0,7],[6,6]],[8,7]]]"
            ]
        ];
    }

    /**
     * @dataProvider providerReduce()
     */
    public function testReduce($input, $expected)
    {
        $assignment = new Day18();
        $output = $assignment->reduce($input);
        self::assertEquals($expected, $output);
    }

    public function providerReduce(): array
    {
        return [
            ["[[3,[2,[1,[7,3]]]],[6,[5,[4,[3,2]]]]]", "[[3,[2,[8,0]]],[9,[5,[7,0]]]]"],
            ["[[[[[4,3],4],4],[7,[[8,4],9]]],[1,1]]", "[[[[0,7],4],[[7,8],[6,0]]],[8,1]]"]
        ];
    }

    /**
     * @dataProvider providerCalculateMagnitude()
     */
    public function testCalculateMagnitude($input, $expected)
    {
        $assignment = new Day18();
        $output = $assignment->calculate_magnitude($input);
        self::assertEquals($expected, $output);
    }

    public function providerCalculateMagnitude(): array
    {
        return [
            ["[9,1]", 29],
            ["[[9,1],[1,9]]", 129],
            ["[[1,2],[[3,4],5]]", 143],
            ["[[[[0,7],4],[[7,8],[6,0]]],[8,1]]", 1384],
            ["[[[[1,1],[2,2]],[3,3]],[4,4]]", 445],
            ["[[[[3,0],[5,3]],[4,4]],[5,5]]", 791],
            ["[[[[5,0],[7,4]],[5,5]],[6,6]]", 1137],
            ["[[[[8,7],[7,7]],[[8,6],[7,7]]],[[[0,7],[6,6]],[8,7]]]", 3488],
        ];
    }
}
