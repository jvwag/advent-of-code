<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2021;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2021\Day14;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2021
 */
class Day14Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day14::class;

    public function testDay14(): void
    {
        $assignment = new Day14();
        $assignment->setInput("NNCB\n\nCH -> B\nHH -> N\nCB -> H\nNH -> C\nHB -> C\nHC -> B\nHN -> C\nNN -> C\nBH -> H\nNC -> B\nNB -> B\nBN -> B\nBB -> N\nBC -> B\nCC -> N\nCN -> C\n");
        $output = $assignment->run();

        self::assertEquals(1588, $output[0]);
        self::assertEquals(2188189693529, $output[1]);
    }
}
