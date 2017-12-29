<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2017\DayTemplate;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class DayTemplateTest extends AssignmentTestCase
{
    protected const TEST_CLASS = DayTemplate::class;

    public function testDayTemplate()
    {
        $assignment = new DayTemplate();
        $assignment->setInput("");
        $output = $assignment->run();

        self::assertEquals(null, $output[0]);
        self::assertEquals(null, $output[1]);
    }
}
