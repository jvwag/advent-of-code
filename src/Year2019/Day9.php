<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2019;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2019
 */
class Day9 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $program = array_map("intval", explode(",", trim($this->getInput())));

        // return answers
        return
            [
                $this->run1($program),
                $this->run2($program),
            ];
    }

    public function run1(array $program): int
    {
        return (new IntcodeComputer($program, [1]))->runToLastOutput();
    }

    public function run2(array $program): int
    {
        return (new IntcodeComputer($program, [2]))->runToLastOutput();
    }

}