<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2020;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2020
 */
class Day3 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input to grid
        $grid = array_map("str_split", explode("\n", trim($this->getInput())));

        // define angles of slope
        $angles = [[3,1], [1,1], [5,1], [7,1], [1,2]];

        // get constraints of our grid
        $width = count($grid[0]);
        $height = count($grid);

        // init vars
        $hits = [];

        // loop over all angles
        foreach($angles as $route => [$angle_x, $angle_y]) {
            $x = $y = $hit = 0;
            // traverse grit as long as we are not down the hill
            while($y < $height) {
                // determine if we hit a tree, if so add one
                // the x axis is repeating, so we will use $x mod $width to determine the locations of grid
                $hit += $grid[$y][$x % $width] === "#" ? 1 : 0;

                // move our location
                $x += $angle_x;
                $y += $angle_y;
            }
            // keep track of the amount of tree's hit in our route
            $hits[$route] = $hit;
        }

        // return answers
        return
            [
                $hits[0], // only the first route
                array_product($hits), // product of trees hit in our route
            ];
    }
}