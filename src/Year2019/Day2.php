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
    private const ADD = 1;
    private const MUL = 2;
    private const END = 99;

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

        return $this->process($program)[0];
    }

    public function run2(array $program): int
    {
        // loop over 100*100 possible nouns and verbs
        for ($program[1] = 0; $program[1] < 100; $program[1]++) {
            for ($program[2] = 0; $program[2] < 100; $program[2]++) {
                // to find this magic solution
                if ($this->process($program)[0] === 19690720) {
                    // return noun * 100 + verb
                    return $program[1] * 100 + $program[2];
                }
            }
        }

        assert("No solution found");

        return 0;
    }

    public function process(array $program): array
    {
        $pointer = 0;

        while (true) {
            switch ($program[$pointer]) {
                case self::ADD:
                    $program[$program[$pointer + 3]] = $program[$program[$pointer + 1]] + $program[$program[$pointer + 2]];
                    break;
                case self::MUL:
                    $program[$program[$pointer + 3]] = $program[$program[$pointer + 1]] * $program[$program[$pointer + 2]];
                    break;
                case self::END:
                    break 2;
                default:
                    assert("Invalid instruction " . $program[$pointer] . " on pos " . $pointer);
            }
            $pointer += 4;
        }

        return $program;
    }
}