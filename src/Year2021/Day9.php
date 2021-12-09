<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2021;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2021
 */
class Day9 extends Assignment
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

        // determine width and height based on initial grid
        $width = count($grid[0]);
        $height = count($grid);

        // initialize an array of basin sizes and sum of lowest points counter
        $basin_sizes = [];
        $sum_of_lowest_points = 0;

        // loop over all elements
        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                // call recursive function to determine a size and the lowest point of a basin
                [$size, $lowest] = $this->recurse($x, $y, $grid);

                // sum of the lowest point values plus one
                $sum_of_lowest_points += ($lowest !== null) ? $lowest + 1 : 0;

                // add a size to the array of basin sizes
                $basin_sizes[] = $size;
            }
        }


        // sort the basins and multiply the last three values (only three!, thanks Matthijs!)
        sort($basin_sizes);
        $multiplication_of_three_largest_basins = array_product(array_slice($basin_sizes, -3));

        // return answers
        return
            [
                $sum_of_lowest_points,
                $multiplication_of_three_largest_basins
            ];
    }

    private function recurse(int $x, int $y, array &$grid, int $lowest = null): ?array
    {
        // only process this leaf if the grid element still exists, and the value is smaller than 9
        if (isset($grid[$y][$x]) && $grid[$y][$x] < 9) {
            // determine the current lowest value found in a basin
            if ($lowest === null || $grid[$y][$x] < $lowest) {
                $lowest = $grid[$y][$x];
            }

            // set the size to one because we have a value smaller than 9
            $size = 1;

            // unset the grid element because we do not want to find it again
            unset($grid[$y][$x]);

            // look for the elements around this element
            foreach ([[-1, 0], [1, 0], [0, 1], [0, -1]] as [$offset_y, $offset_x]) {
                // and call recursion on this new branch
                [$branch_size, $branch_lowest] = $this->recurse($x + $offset_x, $y + $offset_y, $grid, $lowest);

                // determine if the lowest value of a branch is lower than our current value
                if ($branch_lowest !== null && $branch_lowest < $lowest) {
                    $lowest = $branch_lowest;
                }

                // add the size of the branch to the total size
                $size += $branch_size;
            }

            // return only if we are processing a valid grid-point
            return [$size, $lowest];
        }

        // and null if the grid-point was already deleted, or non-existent because it falls outside the grid
        return null;
    }

}