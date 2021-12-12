<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2021;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2021\Day12;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2021
 */
class Day12Test extends AssignmentTestCase
{
    protected const TEST_CLASS = Day12::class;

    public function testDay12Example1(): void
    {
        $assignment = new Day12();
        $assignment->setInput("start-A\nstart-b\nA-c\nA-b\nb-d\nA-end\nb-end\n");
        $output = $assignment->run();

        self::assertEquals(10, $output[0]);
        self::assertEquals(36, $output[1]);
    }

    public function testDay12Example2(): void
    {
        $assignment = new Day12();
        $assignment->setInput("dc-end\nHN-start\nstart-kj\ndc-start\ndc-HN\nLN-dc\nHN-end\nkj-sa\nkj-HN\nkj-dc\n");
        $output = $assignment->run();

        self::assertEquals(19, $output[0]);
        self::assertEquals(103, $output[1]);
    }

    public function testDay12Example3(): void
    {
        $assignment = new Day12();
        $assignment->setInput(
            "fs-end\nhe-DX\nfs-he\nstart-DX\npj-DX\nend-zg\nzg-sl\nzg-pj\n" .
            "pj-he\nRW-he\nfs-DX\npj-RW\nzg-RW\nstart-pj\nhe-WI\nzg-he\npj-fs\nstart-RW\n");
        $output = $assignment->run();

        self::assertEquals(226, $output[0]);
        self::assertEquals(3509, $output[1]);
    }
}
