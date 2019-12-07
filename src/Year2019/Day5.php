<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2019;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2019
 */
class Day5 extends Assignment
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
                $this->solve($program, 1),
                $this->solve($program, 5),
            ];
    }

    public function solve(array $program, $input): int {
        return (new IntcodeComputer($program, [$input]))->runToLastOutput();
    }
}