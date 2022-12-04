<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2022;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2022
 */
class Day3 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // take the sum of al priorities
        $sum_of_priorities_spit_bag = array_sum(
        // by taking each bag (each row of the input)
            array_map(function ($bags) {
                // and split the bag in the middle into two bags
                $bags = str_split($bags, strlen($bags) / 2);
                // and convert the ascii character to a score
                return $this->asciiToScore(
                // given the first value (and only) of the intersection
                    array_values(
                        array_intersect(
                        // of the found unique characters in each bag
                            array_keys(count_chars($bags[0], 1)),
                            array_keys(count_chars($bags[1], 1))
                        )
                    )[0]
                );
            }, explode("\n", trim($this->getInput())))
        );


        $sum_of_priorities_group_of_bags = 0;
        // here we loop over the input in chunks of three rows
        foreach (array_chunk(explode("\n", trim($this->getInput())), 3) as $group) {
            $badges = [];
            // and take each group of three bags each
            foreach ($group as $bags) {
                // take each found character of all these bags
                foreach (array_keys(count_chars($bags, 1)) as $char) {
                    // and add it to a list of badges
                    $badges[$char] = isset($badges[$char]) ? $badges[$char] + 1 : 1;
                }
            }
            // now find the character (and hopefully the only one) that has three occurrences
            $sum_of_priorities_group_of_bags += $this->asciiToScore(array_search(3, $badges));
        }

        // return answers
        return
            [
                $sum_of_priorities_spit_bag,
                $sum_of_priorities_group_of_bags
            ];
    }

    /**
     * Convert ascii code number and convert to score: a-z => 1-26, A-Z => 27-52
     * @param int $ord
     * @return int
     */
    private function asciiToScore(int $ord): int
    {
        return $ord < 97 ? $ord - 64 + 26 : $ord - 96;
    }
}