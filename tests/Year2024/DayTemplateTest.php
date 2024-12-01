<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2024;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2024\DayTemplate;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2024
 */
class DayTemplateTest extends AssignmentTestCase
{
    protected const TEST_CLASS = DayTemplate::class;

    public function testDayTemplate(): void
    {
        $assignment = new DayTemplate();
        $assignment->setInput("");
        $output = $assignment->run();

        self::assertEquals(null, $output[0]);
        self::assertEquals(null, $output[1]);
    }
}
