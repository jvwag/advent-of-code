<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2017;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2017
 */
class Day6 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // get input
        $mem = \explode("\t", trim($this->getInput()));

        // init output
        $output1 = 0;
        $output2 = null;

        // set initial vars
        $c = \count($mem);

        // loop until we find a same state
        $states = [];
        while(!\in_array($mem, $states, true)) {
            // store the current state (and the current step for answer 2)
            $states[$output1] = $mem;

            // determine the memory with the largest value
            $i = \array_search(max($mem), $mem, true);

            // get the value
            $j = $mem[$i];

            // reset the memory value to 0
            $mem[$i] = 0;

            // loop over following memory spaces and adding one
            for($k = 0; $k < $j; $k++) {
                $mem[($i + $k + 1) % $c]++;
            }

            // the number of steps we did is the first answer
            $output1++;
        }

        // the second answer is the total number of steps minus the step the first state found that causes a loop
        $output2 = $output1 - array_search($mem, $states, true);

        // return answers
        return
            [
                $output1,
                $output2
            ];
    }
}