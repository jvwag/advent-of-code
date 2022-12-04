<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2022;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2022
 */
class Day4 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // initialize answers
        $complete_overlapping_areas = 0;
        $partially_overlapping_areas = 0;

        // loop over all areas
        foreach (explode("\n", trim($this->getInput())) as $line) {

            // convert two pairs in an array of two arrays: 2-4,6-8 -> [[2,4],[6,8]]
            $pairs = array_map(function ($a) {
                return array_map("intval", explode("-", $a));
            }, explode(",", trim($line)));


            // check if the areas overlap completely (and both ways)
            if (
                ($pairs[0][0] >= $pairs[1][0] && $pairs[0][0] <= $pairs[1][1] && $pairs[0][1] >= $pairs[1][0] && $pairs[0][1] <= $pairs[1][1]) ||
                ($pairs[1][0] >= $pairs[0][0] && $pairs[1][0] <= $pairs[0][1] && $pairs[1][1] >= $pairs[0][0] && $pairs[1][1] <= $pairs[0][1])
            ) {
                $complete_overlapping_areas++;
            }

            // check if any of the areas overlap
            if (
                ($pairs[0][0] >= $pairs[1][0] && $pairs[0][0] <= $pairs[1][1]) ||
                ($pairs[0][1] >= $pairs[1][0] && $pairs[0][1] <= $pairs[1][1]) ||
                ($pairs[1][0] >= $pairs[0][0] && $pairs[1][0] <= $pairs[0][1]) ||
                ($pairs[1][1] >= $pairs[0][0] && $pairs[1][1] <= $pairs[0][1])
            ) {
                $partially_overlapping_areas++;
            }
        }

        // return answers
        return
            [
                $complete_overlapping_areas,
                $partially_overlapping_areas
            ];
    }
}