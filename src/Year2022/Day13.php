<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2022;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2022
 */
class Day13 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert the input by
        // 1. remove all spacing between groups
        // 2. put all lines (packets) in one array
        // 3. use json_decode to parse the array
        $packets = array_map("json_decode",
            explode("\n",
                str_replace("\n\n", "\n",
                    trim($this->getInput())
                )
            )
        );

        // init the part1 answer
        $indices_sum_of_pairs_where_left_is_smaller = 0;

        // loop over all packets in chunks of two (pairs)
        foreach (array_chunk($packets, 2) as $index => [$left, $right]) {
            // compare the pairs, and only if the left is smaller
            if ($this->compare($left, $right) === -1)
                // add the index (offset by 1 in our array) to the sum of indices
                $indices_sum_of_pairs_where_left_is_smaller += $index + 1;
        }

        // add two markers to the packet list
        $packets[] = $marker1 = [[2]];
        $packets[] = $marker2 = [[6]];

        // sort the array using the compare function
        usort($packets, [$this, "compare"]);

        // search the index positions (off by one) after sorting of markers1 and 2, and use the product as the answer
        $product_of_marker_index_numbers = (array_search($marker1, $packets) + 1) * (array_search($marker2, $packets) + 1);

        // return answers
        return
            [
                $indices_sum_of_pairs_where_left_is_smaller,
                $product_of_marker_index_numbers
            ];
    }

    private function compare(int|array $left, int|array $right): int
    {
        // find the type of comparison we need to do
        if (is_int($left)) {
            if (is_int($right)) {
                // $left and $right are int
                return $left <=> $right;
            } else {
                // $left is int, $right is an array
                return $this->compare([$left], $right);
            }
        } elseif (is_int($right)) {
            // $left is an array, $right is int
            return $this->compare($left, [$right]);
        }

        // $left and $right are arrays, loop while we have elements in $a or $b
        while ($left && $right) {
            // take the next two elements from $left and $right, and compare them... we will continue until they are equal
            if (($c = $this->compare(array_shift($left), array_shift($right))) !== 0) {
                return $c;
            }
        }

        // so we are done comparing the array, are there still some elements in the left and right array?
        if ($right) {
            // if there is some elements in right return lower
            return -1;
        } elseif ($left) {
            // if there are some element in left return higher
            return 1;
        }
        // no more elements to compare: equal
        return 0;


    }
}