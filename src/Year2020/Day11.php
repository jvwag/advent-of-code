<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2020;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2020
 */
class Day11 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // parse input to grid
        $grid = [];
        foreach (explode("\n", trim($this->getInput())) as $y => $line) {
            foreach (str_split($line) as $x => $char) {
                $grid[$x][$y] = $char;
            }
        }

        // return answers
        return
            [
                $this->stepGrid($grid, true, 3),
                $this->stepGrid($grid, false, 4)
            ];
    }

    private function stepGrid(array $grid, bool $limit_range, int $max_occupied_seats): int
    {
        // initialize values
        $width = count($grid);
        $height = count($grid[0]);

        do {
            // create a copy of the grid, the copy is used for storing new values, the original grid is used for lookups
            $grid_copy = $grid;

            // init a seat counter that stores the answer after all iterations
            $occupied_seat_counter = 0;

            // init a change flag, to stop iterating if nothing was changed
            $change = false;

            // loop over all locations in the grid
            for ($y = 0; $y < $height; $y++) {
                for ($x = 0; $x < $width; $x++) {
                    // if there is a chair
                    if ($grid[$x][$y] !== ".") {
                        // init array for counting adjacent locations
                        $count = ["#" => 0, "." => 0, "L" => 0];

                        /**
                         * Definition needed for PphStorm bug: https://youtrack.jetbrains.com/issue/WI-57520
                         * @var int $y_step
                         */
                        // loop over all directions around the current position
                        foreach ([[-1, -1], [0, -1], [1, -1], [1, 0], [1, 1], [0, 1], [-1, 1], [-1, 0]] as [$x_step, $y_step]) {
                            // step the range up
                            $z = 0;
                            while (++$z) {
                                // calculate the location given the direction and the range
                                $x2 = $x + ($x_step * $z);
                                $y2 = $y + ($y_step * $z);

                                // if the location falls off the grid, break and use another direction
                                if (!isset($grid[$x2][$y2])) {
                                    break;
                                }

                                // add the adjacent tile to the count array
                                $count[$grid[$x2][$y2]]++;

                                // if we have a limited range, or we have found something else than an empty
                                // tile: break and use another direction
                                if ($limit_range || $grid[$x2][$y2] !== ".") {
                                    break;
                                }
                            }
                        }

                        // if we are on an unoccupied chair, and there are no occupied chairs counted around us
                        if ($grid[$x][$y] === "L" && $count["#"] === 0) {
                            // take a seat
                            $grid_copy[$x][$y] = "#";
                            // and take note this step there was a change
                            $change = true;
                        }

                        // if we are seated, and it gets a bit too crowded (more seats are taken than given)
                        if ($grid[$x][$y] === "#" && $count["#"] > $max_occupied_seats) {
                            // stand up and walk away
                            $grid_copy[$x][$y] = "L";
                            // and take note this step there was a change
                            $change = true;
                        }
                    }
                    // here we just count the number of occupied seats because this is the answer to the given assignment
                    if ($grid_copy[$x][$y] === "#") {
                        $occupied_seat_counter++;
                    }
                }
            }
            // copy the modified grid to the original grid
            $grid = $grid_copy;

            // loop while there is change
        } while ($change);


        // return if there was any change
        return $occupied_seat_counter;
    }

}