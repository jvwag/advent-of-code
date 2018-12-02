<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2015;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2015\DayTemplate;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2015
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
