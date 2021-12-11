<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2021;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2021
 */
class Day11 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input to a grid of integers ($grid[y][x])
        $grid = array_map(function ($a) {
            return array_map("intval", str_split($a));
        }, explode("\n", trim($this->getInput())));

        // determine width and height and number of element of the initial grid
        $width = count($grid[0]);
        $height = count($grid);
        $total_elements_in_grid = $height * $width;

        // init variables
        $flashes_this_step = $total_number_of_flashes = $step = 0;

        // loop until we have found a step with 100 flashes (all elements in the grid)
        while ($flashes_this_step !== $total_elements_in_grid) {

            // increment the step value
            $step++;

            // loop over all elements
            for ($y = 0; $y < $height; $y++) {
                for ($x = 0; $x < $width; $x++) {

                    // and increment every energy value by one
                    $grid[$y][$x]++;
                }
            }

            $flashes_this_step = 0;
            // loop over all elements
            for ($y = 0; $y < $height; $y++) {
                for ($x = 0; $x < $width; $x++) {

                    // and check if the current location, and adjacent (recursive), for flashes
                    $flashes_this_step += $this->recurse($x, $y, $grid);
                }
            }

            // up to step 100, we will need to sum the total number of flashes for the answer to part one of the assignment
            if($step <= 100) {
                $total_number_of_flashes += $flashes_this_step;
            }

            // loop over all elements
            for ($y = 0; $y < $height; $y++) {
                for ($x = 0; $x < $width; $x++) {

                    // and set the energy value to 0 if it was higher than 9
                    if ($grid[$y][$x] > 9) {
                        $grid[$y][$x] = 0;
                    }
                }
            }
        }

        // return answers
        return
            [
                $total_number_of_flashes,
                $step // the last step until we found 100% of grid in a flash
            ];
    }

    private function recurse(int $x, int $y, array &$grid): int
    {
        // init a counter to count the number of flashes
        $c = 0;

        // we will ony process an element when it has reached energy level 10
        if ($grid[$y][$x] === 10) {

            // and set the counter to one, we have found a flash
            $c = 1;

            // and increment the level to 11, so it will not be processed in this recursion again
            $grid[$y][$x]++;

            // now loop over all adjacent elements
            foreach ([[-1, -1], [-1, 0], [-1, 1], [0, 1], [1, 1], [1, 0], [1, -1], [0, -1]] as [$offset_y, $offset_x]) {

                // if the adjacent element exists, and it is not in a flashing state (10 or higher)
                if (isset($grid[$y + $offset_y][$x + $offset_x]) && $grid[$y + $offset_y][$x + $offset_x] < 10) {

                    // increment the adjacent elements value by one
                    $grid[$y + $offset_y][$x + $offset_x]++;

                    // and process this element to see if it has reached the flashing state
                    $c += $this->recurse($x + $offset_x, $y + $offset_y, $grid);
                }
            }
        }

        // return the number of flashes in this part of the recursion
        return $c;
    }
}