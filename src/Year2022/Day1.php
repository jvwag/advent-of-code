<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2022;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2022
 */
class Day1 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input by:
        // 1. splitting into groups
        // 2. put the values of each group in an array
        // 3. take the sum of the array
        $calories_per_elf = array_map("array_sum", array_map(function ($a) {
            return explode("\n", $a);
        }, explode("\n\n", $this->getInput())));

        // sort the list of calories per elf, numeric, descending
        rsort($calories_per_elf, SORT_NUMERIC);

        // return answers
        return
            [
                // the elf with the most calories is the first in the list
                $calories_per_elf[0],
                // second assignment is the sum of the top three elves with the most calories
                array_sum(array_slice($calories_per_elf, 0, 3))
            ];
    }
}