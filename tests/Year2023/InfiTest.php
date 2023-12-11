<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2023;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2023\Infi;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2022
 */
class InfiTest extends AssignmentTestCase
{
    protected const TEST_CLASS = Infi::class;

    public function testDayTemplate(): void
    {
        $assignment = new Infi();
        $assignment->setInput("(0, 4), (3, -2), (-1, -2), (-2, 0)\n");
        $output = $assignment->run();

        self::assertEquals(4, $output[0]);
        self::assertEquals(null, $output[1]);
    }
}
