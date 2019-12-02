<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests\Year2019;

use jvwag\AdventOfCode\Tests\AssignmentTestCase;
use jvwag\AdventOfCode\Year2019\Infi;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Tests\Year2019
 */
class InfiTest extends AssignmentTestCase
{
    protected const TEST_CLASS = Infi::class;

    public function testDayTemplate(): void
    {
        $assignment = new Infi();
        /** @noinspection JsonEncodingApiUsageInspection */
        $input = json_decode('{"flats": [[1,4],[3,8],[4,3],[5,7],[7,4],[10,3]],"sprongen": [[2,0],[0,4],[1,0],[0,0]]}');
        $output = $assignment->run1($input);

        self::assertEquals(4, $output);
    }
}
