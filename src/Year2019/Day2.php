<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2019;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2019
 */
class Day2 extends Assignment
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
                $this->run2($program)
            ];
    }

    public function run1(array $program): int
    {
        // configure given program adjustments
        $program[1] = 12;
        $program[2] = 2;
        $computer = new IntcodeComputer($program);
        $computer->runToEnd();
        return $computer->getProgram()[0];
    }

    public function run2(array $program): int
    {
        // loop over 100*100 possible nouns and verbs
        for ($program[1] = 0; $program[1] < 100; $program[1]++) {
            for ($program[2] = 0; $program[2] < 100; $program[2]++) {
                // to find this magic solution
                $computer = new IntcodeComputer($program);
                $computer->runToEnd();
                if ($computer->getProgram()[0] === 19690720) {
                    // return noun * 100 + verb
                    return $program[1] * 100 + $program[2];
                }
            }
        }

        assert(false, "No solution found");

        return 0;
    }
}