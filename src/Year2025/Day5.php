<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2025;

use jvwag\AdventOfCode\Assignment;

class Day5 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // split the input to ingredients and ranges
        [$ranges, $ingredients] = explode("\n\n", trim($this->getInput()));

        // convert the ingredient numbers to integers
        $ingredients = array_map("intval", explode("\n", trim($ingredients)));

        // convert the ranges to an array of arrays with a min and max integer [[min,max],[min,max],...]
        $ranges = array_map(function ($range) {
            return array_map("intval", explode("-", $range));
        }, explode("\n", trim($ranges)));

        // also, sort the ranges list based on the min value for part2
        usort($ranges, function ($a, $b) {
            return $a[0] <=> $b[0];
        });

        // init answers
        $available_fresh_ingredients = $total_fresh_ingredients = 0;

        // loop over all the ingredients
        foreach ($ingredients as $ingredient) {
            // loop over the ranges
            foreach ($ranges as [$min, $max]) {
                //if the ingredient is within a range
                if ($ingredient >= $min && $ingredient <= $max) {
                    // count is fresh and go to the next ingredient
                    $available_fresh_ingredients++;
                    break;
                }
            }
        }

        //
        $reduced_ranges = [];
        $current = $ranges[0];
        // loop over all ranges
        foreach ($ranges as $i => $range) {
            // but skip the first
            if ($i === 0) {
                continue;
            }

            // see if the current max value is in the range we are currently comparing to
            if ($current[1] >= $range[0]) {
                // it is in the range: set the max of the current range to the max of the comparing range if it's higher
                $current[1] = max($current[1], $range[1]);
                continue;
            }

            // no overlap, we will store the current range and use the next to compare
            $reduced_ranges[] = $current;
            $current = $range;
        }
        // the last range we used for comparison should also be added, ask me how much time this edge-case took :(
        $reduced_ranges[] = $current;

        // now loop over all the new ranges and sum the range sizes
        foreach ($reduced_ranges as [$min, $max]) {
            $total_fresh_ingredients += $max - $min + 1; // the solution required inclusive ranges, so +1
        }

        // return answers
        return
            [
                $available_fresh_ingredients,
                $total_fresh_ingredients
            ];
    }
}