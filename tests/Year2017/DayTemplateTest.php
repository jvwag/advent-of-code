<?php

namespace jvwag\AdventOfCode\Tests\Year2017;

use jvwag\AdventOfCode\Year2017\DayTemplate;
use PHPUnit\Framework\TestCase;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2017
 */
class DayTemplateTest extends TestCase
{
    public function testDayTemplate()
    {
        $assignment = new DayTemplate();
        $assignment->setInput("");
        $output = $assignment->run();

        self::assertEquals(null, $output[0]);
        self::assertEquals(null, $output[1]);
    }
}
