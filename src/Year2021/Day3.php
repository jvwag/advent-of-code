<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2021;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2021
 */
class Day3 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input to an array containing arrays of binary numbers
        $lines = explode("\n", trim($this->getInput()));
        $list = [];
        foreach ($lines as $line) {
            $list[] = array_map("intval", str_split($line));
        }

        // get some info from the input
        $number_of_lines = count($lines);
        $number_of_bits = strlen($lines[0]);

        // we need the sum of the bits
        $sum = $this->sum_of_elements($list);

        // now we iterate over every value to determine if the sum is high enough to be the most bits
        // if so we will add a one bit to the number, or if not: a zero
        $gamma = array_reduce($sum, function ($carry, $bit) use ($number_of_lines) {
            // move the carry one bit and add a new bit
            return $carry << 1 | $bit > ($number_of_lines / 2);
        }, 0);

        // the epsilon is just the xor'ed version of gamma, only we need to know the original number of bits
        $epsilon = $gamma ^ pow(2, $number_of_bits) - 1;

        // we use a separate function to find o2 and co2 levels
        $o2 = $this->find_o2_or_co2($list, true);
        $co2 = $this->find_o2_or_co2($list, false);

        // return answers
        return
            [
                $gamma * $epsilon,
                $o2 * $co2
            ];
    }

    /**
     * Add all given arrays of numbered arrays, taking the number in each position and returning an array
     * with the sum of the numbers in each position.
     *
     * @param array $list Array with same sized arrays containing numbers
     * @return array Array with in each element the sum of the elements in the given arrays on that same element position
     */
    private function sum_of_elements(array $list): array
    {
        return array_map(function (...$arrays) {
            return array_sum($arrays);
        }, ...$list);
    }

    /**
     * Find a specific number in a list that matches the very specific criteria given in the assignment
     *
     * @param array $list Array containing array with bits
     * @param bool $o2_or_co2 True for O2, and false for CO2
     * @return int Specific number in the list converted to an integer
     */
    private function find_o2_or_co2(array $list, bool $o2_or_co2): int
    {
        // keep track of the current bit we are comparing to
        $bit_pointer = 0;

        // loop until only one value is left
        while (($c = count($list)) > 1) {
            // start with a sum of the elements
            $sum = $this->sum_of_elements($list);

            // different criteria for o2 and co2
            if ($o2_or_co2 === true) {
                // determine the values to be removed based on the sum and the number of values still in the list
                $value_to_remove = $sum[$bit_pointer] < ($c / 2);
            } else {
                $value_to_remove = $sum[$bit_pointer] >= ($c / 2);
            }

            // filter the current list
            $list = array_filter($list, function ($bits) use ($bit_pointer, $value_to_remove) {
                return $bits[$bit_pointer] == $value_to_remove;
            });

            // up to the next bit
            $bit_pointer++;
        }

        // return the decimal value of the last element in the list, and convert that array of bits to an integer
        return bindec(join("", array_pop($list)));
    }
}