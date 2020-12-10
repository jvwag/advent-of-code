<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2020;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year202
 */
class Day10 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        $adapters = array_map("intval", explode("\n", trim($this->getInput())));
        sort($adapters);

        // seed the number of arrangements, we always start with one
        $arrangements[0] = 1;
        // array to count the steps for part1, count one step up and three steps up
        $steps = [1 => 0, 3 => 1];
        // the previous adapter to compare with (the amount of steps between the adapters)
        $previous_adapter = 0;

        // loop over all adapters
        foreach ($adapters as $adapter) {
            // determine the step between this adapter and the previous adapter, and overwrite the previous adapter
            // for next comparison
            $steps[$adapter - $previous_adapter]++;
            $previous_adapter = $adapter;

            //
            $arrangement_sum = 0;
            // loop over the three previous used adapter arrangements calculations
            for ($i = $adapter - 3; $i < $adapter; $i++) {
                // if the arrangement has been calculated
                if (isset($arrangements[$i])) {
                    // and sum the 0 to 3 arrangements numbers together
                    $arrangement_sum += $arrangements[$i];
                }
            }
            // the sum of the previous arrangements is the arrangement for this adapter
            $arrangements[$adapter] = $arrangement_sum;
        }

        // return answers
        return
            [
                $steps[1] * $steps[3], // the product of the 1 and 3 step adapter offsets
                $arrangements[max($adapters)] // the number of arrangements after calculating the last adapter
            ];
    }
}