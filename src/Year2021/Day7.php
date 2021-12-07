<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2021;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2021
 */
class Day7 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input to an array of integers
        $input = array_map("intval", explode(",", trim($this->getInput())));

        // init two arrays with all possible solutions
        $single_fuel_solutions = $inflating_fuel_solutions = [];

        // loop over all positions
        for ($i = min($input); $i <= max($input); $i++) {
            // calculate a single fuel solution
            $single_fuel_solutions[] = array_reduce($input, function ($carry, $value) use ($i) {
                // use the carry to sum, and the difference between the chosen position and a crab
                return $carry + abs($value - $i);
            }, 0);

            // and the same, but now
            $inflating_fuel_solutions[] = array_reduce($input, function ($carry, $value) use ($i) {
                // first determine the distance
                $k = abs($value - $i);
                // and add the sum of a series to the carry (which is carrying the sum of fuel for this position)
                return $carry + (($k * ($k + 1)) / 2);
            }, 0);
        }

        // return answers, the lowest fuel score wins
        return
            [
                min($single_fuel_solutions),
                min($inflating_fuel_solutions)
            ];
    }
}