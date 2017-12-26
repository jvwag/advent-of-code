<?php

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Year2017\Day7;
use PHPUnit\Framework\TestCase;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class Day7Test extends TestCase
{
    public function testDay7()
    {
        $assignment = new Day7();
        $assignment->setInput(
            "pbga (66)\n" .
            "xhth (57)\n" .
            "ebii (61)\n" .
            "havc (66)\n" .
            "ktlj (57)\n" .
            "fwft (72) -> ktlj, cntj, xhth\n" .
            "qoyq (66)\n" .
            "padx (45) -> pbga, havc, qoyq\n" .
            "tknk (41) -> ugml, padx, fwft\n" .
            "jptl (61)\n" .
            "ugml (68) -> gyxo, ebii, jptl\n" .
            "gyxo (61)\n" .
            "cntj (57)\n");
        $output = $assignment->run();

        self::assertEquals("tknk", $output[0]);
        self::assertEquals(60, $output[1]);
    }
}
