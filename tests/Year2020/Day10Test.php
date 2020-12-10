<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2020;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2020\Day10;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2019
 */
class Day10Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day10::class;

    public function testDay10First(): void
    {
        $assignment = new Day10();
        $assignment->setInput("16\n10\n15\n5\n1\n11\n7\n19\n6\n12\n4\n");

        $output = $assignment->run();

        self::assertEquals(35, $output[0]);
        self::assertEquals(8, $output[1]);
    }


    public function testDay10Second(): void
    {
        $assignment = new Day10();
        $assignment->setInput("28\n33\n18\n42\n31\n14\n46\n20\n48\n47\n24\n23\n49\n45\n19\n38\n39\n11\n1\n32\n25\n35\n8\n17\n7\n9\n4\n2\n34\n10\n3\n");

        $output = $assignment->run();

        self::assertEquals(220, $output[0]);
        self::assertEquals(19208, $output[1]);
    }

}
