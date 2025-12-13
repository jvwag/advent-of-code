<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2025;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2025\Infi;

class InfiTest extends AssignmentTestCase
{
    protected const TEST_CLASS = Infi::class;

    public function testInfi(): void
    {
        $assignment = new Infi();
        $assignment->setInput(". . . 1 \n 2 3 . .\n. . . 0 \n 4 . 2 .\n. . . . \n . 0 0 .\n2 0 . . \n . . . .\n");
        $output = $assignment->run();

        self::assertEquals(529, $output[0]);
        self::assertEquals(null, $output[1]);
    }
}
