<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2023;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2023
 */
class Day9 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // initialize output variables
        $sum_of_extrapolated_values = $sum_of_backwards_extrapolated_values = 0;

        // loop over all lines (set of historic values)
        foreach (explode("\n", trim($this->getInput())) as $history) {
            // convert line to array of integers
            $history = array_map("intval", explode(" ", $history));
            // count the number of elements
            $count = count($history);

            // initialize arrays for counting the first and last values
            $first_values = $last_values = [];
            while (true) {
                // store the first and last value of a history iteration
                $last_values[] = $history[$count - 1];
                $first_values[] = $history[0];
                // we will break if all values of history are the same (this will have the same outcome as
                // having a list of all zero's)
                if (count(array_unique($history)) === 1) {
                    break;
                }

                // reduce the array to a set of differences between values
                $out = [];
                for ($i = 1; $i < $count; $i++) {
                    $out[] = $history[$i] - $history[$i - 1];
                }
                $history = $out;

                // reduce the size of the array by one
                $count--;
            }

            // per set of history, add the sum of the last values as the answer
            $sum_of_extrapolated_values += array_sum($last_values);
            // for the backwards extrapolated values, walk over all elements in the array in reverse, and subtracting
            // each following number
            $sum_of_backwards_extrapolated_values += array_reduce(array_reverse($first_values), function ($carry, $v) {
                return $v - $carry;
            });
        }

        return
            [
                $sum_of_extrapolated_values,
                $sum_of_backwards_extrapolated_values
            ];
    }
}