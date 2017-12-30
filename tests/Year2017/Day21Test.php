<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2017\Day21;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day21Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day21::class;

    public function testDay21()
    {
        $assignment = new Day21();
        $rules = $assignment->parseRules(
            "../.# => ##./#../...\n" .
            ".#./..#/### => #..#/..../..../#..#\n"
        );

        $output = $assignment->run1(Day21::BASE, $rules, 2);

        self::assertEquals(12, $output);
    }

    public function testDay21Rot()
    {
        $assignment = new Day21();
        self::assertEquals("51/62/73/84", $assignment->rotate("1234/5678"));
        self::assertEquals("7531/8642", $assignment->rotate("12/34/56/78"));
        self::assertEquals("31/42", $assignment->rotate("12/34"));
        self::assertEquals("741/852/963", $assignment->rotate("123/456/789"));

        self::assertEquals("5678/1234", $assignment->flip("1234/5678"));
        self::assertEquals("78/56/34/12", $assignment->flip("12/34/56/78"));
        self::assertEquals("34/12", $assignment->flip("12/34"));
        self::assertEquals("789/456/123", $assignment->flip("123/456/789"));

        self::assertEquals(
            ["abc/def/ghi"],
            $assignment->split("abc/def/ghi")
        );

        self::assertEquals(
            ["ab/ef", "cd/gh", "ij/mn", "kl/op"],
            $assignment->split("abcd/efgh/ijkl/mnop")
        );

        self::assertEquals(
            ["ab/gh", "cd/ij", "ef/kl", "mn/st", "op/uv", "qr/wx", "yz/56", "12/78", "34/90"],
            $assignment->split("abcdef/ghijkl/mnopqr/stuvwx/yz1234/567890")
        );

        self::assertEquals(
            ["a.0/b.1/c.2", "d-4/e-5/f-6", "g*7/h*8/i*9", "j.0/k.1/l.2", "m-4/n-5/o-6", "p*7/q*8/r*9", "s.0/t.1/u.2", "v-4/w-5/x-6", "y*7/z*8/!*9"],
            $assignment->split("a.0d-4g*7/b.1e-5h*8/c.2f-6i*9/j.0m-4p*7/k.1n-5q*8/l.2o-6r*9/s.0v-4y*7/t.1w-5z*8/u.2x-6!*9")
        );

        self::assertEquals(
            "abc/def/ghi",
            $assignment->join(["abc/def/ghi"])
        );

        self::assertEquals(
            "abcd/efgh/ijkl/mnop",
            $assignment->join(["ab/ef", "cd/gh", "ij/mn", "kl/op"])
        );

        self::assertEquals(
            "abcdef/ghijkl/mnopqr/stuvwx/yz1234/567890",
            $assignment->join(["abc/ghi/mno", "def/jkl/pqr", "stu/yz1/567", "vwx/234/890"])
        );

        self::assertEquals(
            "a.0d-4g*7/b.1e-5h*8/c.2f-6i*9/j.0m-4p*7/k.1n-5q*8/l.2o-6r*9/s.0v-4y*7/t.1w-5z*8/u.2x-6!*9",
            $assignment->join(["a.0/b.1/c.2", "d-4/e-5/f-6", "g*7/h*8/i*9", "j.0/k.1/l.2", "m-4/n-5/o-6", "p*7/q*8/r*9", "s.0/t.1/u.2", "v-4/w-5/x-6", "y*7/z*8/!*9"])
        );

    }
}
