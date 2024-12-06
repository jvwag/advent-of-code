<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2024;

use jvwag\AdventOfCode\Assignment;

class Day6 extends Assignment
{
    public function run(): array
    {
        // init grid and starting point, we use y,x coordinates because a nested array[y][x] is
        // easier to print while debugging
        $grid = $start = [];

        // parse the input
        foreach (explode("\n", trim($this->getInput())) as $parse_y => $line) {
            foreach (str_split(trim($line)) as $parse_x => $column) {
                $grid[$parse_y][$parse_x] = $column;
                // if we find the starting position: store the coordinates
                if ($column == "^") {
                    $start = [$parse_y, $parse_x];
                }
            }
        }

        // walk the grid from the starting position, and use the visited positions for part2
        $visited_positions = $this->walkRoute($grid, $start);

        $number_of_loop_routes = 0;
        // loop over all visited positions
        foreach ($visited_positions as $obstacle) {
            // each visited position is a position where we could place an obstacle
            // walk each of these routes
            if ($this->walkRoute($grid, $start, $obstacle) === null) {
                // if the route was infinite, add this to the result counter
                $number_of_loop_routes++;
            }
        }

        // return answers
        return
            [
                count($visited_positions),
                $number_of_loop_routes
            ];
    }

    function walkRoute(array $grid, array $start, array $obstacle = null): ?array
    {
        // set the starting position and calculating the size of the grid
        [$y, $x] = $start;
        [$max_y, $max_x] = [count($grid), count($grid[0])];

        // lookup table for 4 directions
        $directions = [[-1, 0], [0, 1], [1, 0], [0, -1]];

        // init variables
        $visited_positions = $visited_positions_with_direction = [];
        $direction = 0;

        // if there is an obstacle argument, place the obstacle in the grid
        if ($obstacle) {
            $grid[$obstacle[0]][$obstacle[1]] = "#";
        }

        // keep walking until we reach the edge of the grid
        while ($x >= 0 && $y >= 0 && $x < $max_x && $y < $max_y) {
            // determine the offset in x/y coordinates we need to make given the direction
            [$y_offset, $x_offset] = $directions[$direction];

            // we are on a valid location, we will add this location to our list nof
            $visited_positions[] = [$y, $x];

            // if we are in part two, and we added an obstacle, if we encounter we have been on this position before
            // AND we are also facing the same way as before, we are walking an infinite loop
            if (isset($obstacle) && isset($visited_positions_with_direction["$y/$x/$direction"])) {
                return null;
            }
            // if we encounter an obstacle
            if (($grid[$y + $y_offset][$x + $x_offset] ?? "") === "#") {
                // we will record the position we are in, and the direction we are facing
                $visited_positions_with_direction["$y/$x/$direction"] = true;

                // and move 90 degrees clockwise
                $direction = ($direction + 1) % 4;
            } else {
                // make sure we -or- move, -or- change direction...  ..#..
                // always moving after a turn will make you skip     ..^#. <-
                // two obstacles that are close together             .....
                // debugging this with large input and minimal cases took quite some time :(
                $y += $y_offset;
                $x += $x_offset;
            }
        }
        // if we are doing part2, there is no need to return the complete array
        if (isset($obstacle)) {
            return [];
        } else {
            // the part1 return array should be unique, we do not only need the sum of the positions
            // but also all positions to use this as input for part2
            return array_unique($visited_positions, SORT_REGULAR);
        }
    }
}