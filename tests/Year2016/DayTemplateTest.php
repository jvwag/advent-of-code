<?php

namespace jvwag\AdventOfCode\Tests\Year2016;

use jvwag\AdventOfCode\Year2016\DayTemplate;
use PHPUnit\Framework\TestCase;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2016
 */
class DayTemplateTest extends TestCase
{
    public function testDayX()
    {
        $assignment = new DayTemplate();
        $assignment->setInput("");
        $output = $assignment->run();

        self::assertEquals(null, $output[0]);
        self::assertEquals(null, $output[1]);
    }
}
