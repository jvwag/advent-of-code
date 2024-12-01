<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2024;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2023
 */
class DayTemplate extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        /** @noinspection PhpUnusedLocalVariableInspection */
        $input = $this->getInput();

        // init output
        $output1 = null;
        $output2 = null;

        // return answers
        return
            [
                $output1,
                $output2
            ];
    }
}