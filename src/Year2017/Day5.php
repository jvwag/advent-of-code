<?php

namespace jvwag\AdventOfCode\Year2017;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2017
 */
class Day5 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $jumps = \array_map(
            function ($x) {
                return (int) trim($x);
            },
            \explode("\n", \trim($this->getInput()))
        );

        // return answers
        return
            [
                $this->calculate($jumps, false),
                $this->calculate($jumps, true),
            ];
    }

    /**
     * @param int[] $jumps
     * @param bool $method
     *
     * @return int
     */
    public function calculate(array $jumps, bool $method): int
    {
        // init vars
        $steps = 0;
        $i = 0;
        $l = \count($jumps);

        // follow jumps until we jump out of bounds
        while ($i >= 0 && $i < $l) {
            // the number of steps is the answer
            $steps++;

            // find the next step
            $j = $jumps[$i];

            // based on the method, find the next value for the current jump position
            $jumps[$i] += ($method === true && $j > 2) ? -1 : 1;

            // set the program pointer to the next jump location
            $i += $j;
        }

        return $steps;
    }
}