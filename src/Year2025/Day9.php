<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2025;

use jvwag\AdventOfCode\Assignment;

class Day9 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input to list of coordinates
        $coords = array_map(function ($line) {
            return array_map("intval", explode(",", $line));
        }, explode("\n", trim($this->getInput())));

        // init output and number of coordinates
        $largest_area_of_all_possible_rectangles = 0;
        $c = count($coords);

        // loop over all possible coordinate combinations
        for ($i = 0; $i < $c; $i++) {
            for ($j = $i + 1; $j < $c; $j++) {
                // calculate the size of the rectangle given the coordinates
                $largest_area_of_all_possible_rectangles =
                    // and save the largest
                    max((max($coords[$i][0], $coords[$j][0]) - min($coords[$i][0], $coords[$j][0]) + 1) * (max($coords[$i][1], $coords[$j][1]) - min($coords[$i][1], $coords[$j][1]) + 1),
                        $largest_area_of_all_possible_rectangles);
            }
        }

        // return answers
        return
            [
                $largest_area_of_all_possible_rectangles,
                null
            ];
    }
}