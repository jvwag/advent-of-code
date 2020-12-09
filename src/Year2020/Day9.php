<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2020;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year202
 */
class Day9 extends Assignment
{
    /**
     * @param int $preamble
     * @return array
     */
    public function run($preamble = 25): array
    {
        // parse the input to array of integers
        $arr = array_map("intval", explode("\n", $this->getInput()));

        // init output
        $output1 = $this->run1($arr, $preamble); // find the first error in the number list
        $output2 = $this->run2($arr, $output1); // find the series of numbers equal to the value of the first error

        // return answers
        return
            [
                $output1,
                $output2
            ];
    }

    /**
     * Loop over all numbers to find the number with the encoding error
     *
     * @param int[] $numbers Array of integers
     * @param int $preamble_size Number of values to check for valid encoding
     * @return int|null The value with the error or null if not found
     */
    public function run1(array $numbers, int $preamble_size): ?int
    {
        // loop over all numbers, starting just after the preamble
        $i = $preamble_size;
        $l = count($numbers);
        while ($i < $l) {
            // check if the preamble (the x values before the current value)
            if (!$this->check(array_slice($numbers, $i - $preamble_size, $preamble_size), $numbers[$i])) {
                // if the check failed, return the current number
                return $numbers[$i];
            }
            // step to the next numbers
            $i++;
        }

        return null;
    }

    /**
     * Find two non equal values where the sum equals the target numbers
     *
     * @param int[] $numbers Array of integers
     * @param int $target Target number to check
     * @return bool True if the number is correct, false if not
     */
    public function check(array $numbers, int $target): bool
    {
        // loop over the array comparing all numbers with each other
        $c = count($numbers);
        for ($x = 0; $x < $c; $x++) {
            for ($y = 0; $y < $x; $y++) {
                // find two non equal numbers with the sum equal to the target
                if ($numbers[$x] !== $numbers[$y] && $numbers[$x] + $numbers[$y] === $target) {
                    return true;
                }
            }
        }

        // nothing found
        return false;
    }

    /**
     * Find a series of numbers where the sum is the target, and return the min and max value of that series
     *
     * @param int[] $numbers Array of integers
     * @param int $target Target number to find
     * @return int|null Sum of minimal and maximal value of the series found
     */
    public function run2(array $numbers, int $target): ?int
    {
        // loop over all numbers
        $i = 0;
        $l = count($numbers);
        while ($i < $l) {
            $sum_arr = [];
            $sum = 0;
            $j = $i;
            // create a sum array from the current number until larger than the target number or end of the array
            while ($sum < $target && $j < $l) {
                // increment the sum array
                $sum_arr[] = $numbers[$j];
                // calculate the sum
                $sum = array_sum($sum_arr);
                // if we have more than one value and the sum equals the target number
                if (count($sum_arr) > 1 && $sum === $target) {
                    // return the sum of the min and max value
                    return min($sum_arr) + max($sum_arr);
                }
                // increment the sum pointer
                $j++;
            }
            // increment the pointer in the numbers list
            $i++;
        }

        // null if sum was not found
        return null;
    }
}