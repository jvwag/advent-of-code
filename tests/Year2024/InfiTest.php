<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2024;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2024\Infi;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2024
 */
class InfiTest extends AssignmentTestCase
{
    protected const TEST_CLASS = Infi::class;

    public function testDayTemplate(): void
    {
        $assignment = new Infi();
        $assignment->setInstructions([
            ["push", "999"],
            ["push", "X"],
            ["push", "-3"],
            ["add", null],
            ["jmpos", "2"],
            ["ret", null],
            ["ret", null],
            ["push", "123"],
            ["ret", null]
        ]);
        $result = $assignment->runInstructions(7, 0, 0);

        self::assertEquals(123, $result);

        $sum = 0;
        for ($x = 0; $x < Infi::GRID_MAX; $x++) {
            for ($y = 0; $y < Infi::GRID_MAX; $y++) {
                for ($z = 0; $z < Infi::GRID_MAX; $z++) {
                    $sum += $assignment->runInstructions($x, $y, $z);
                }
            }
        }
        self::assertEquals(5686200, $sum);
    }
}
