<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2015;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2015\Day13;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2015
 */
class Day13Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day13::class;

    public function testDay13()
    {
        $assignment = new Day13();
        $assignment->setInput(
            "Alice would gain 54 happiness units by sitting next to Bob.\n" .
            "Alice would lose 79 happiness units by sitting next to Carol.\n" .
            "Alice would lose 2 happiness units by sitting next to David.\n" .
            "Bob would gain 83 happiness units by sitting next to Alice.\n" .
            "Bob would lose 7 happiness units by sitting next to Carol.\n" .
            "Bob would lose 63 happiness units by sitting next to David.\n" .
            "Carol would lose 62 happiness units by sitting next to Alice.\n" .
            "Carol would gain 60 happiness units by sitting next to Bob.\n" .
            "Carol would gain 55 happiness units by sitting next to David.\n" .
            "David would gain 46 happiness units by sitting next to Alice.\n" .
            "David would lose 7 happiness units by sitting next to Bob.\n" .
            "David would gain 41 happiness units by sitting next to Carol.\n"
        );

        $output = $assignment->run();

        self::assertEquals(330, $output[0]);
        self::assertEquals(286, $output[1]);
    }
}
