<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2021;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2021
 */
class Day13 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // init values
        $grid = [];
        $drawn_grid = "";
        $width = $height = 0;
        $active_coordinates_after_first_fold = null;

        // split the input in coordinates and fold instructions
        [$coordinates, $fold_instructions] = explode("\n\n", trim($this->getInput()));

        // loop over all coordinates
        foreach (explode("\n", $coordinates) as $line) {
            [$x, $y] = explode(",", trim($line));
            // set coordinate in grid and determine maximum coordinates for width and height;
            $grid[$y][$x] = true;
            $height = max($height, $y + 1);
            $width = max($width, $x + 1);
        }

        // loop over all fold instructions
        foreach (explode("\n", $fold_instructions) as $line) {
            if (preg_match("/([xy])=(\d+)$/", $line, $match)) {
                // extract axis and pos, axis is true for y-axis fold, and false for x-axis fold
                $axis = $match[1] === "y";
                $pos = (int)$match[2];

                // loop over all elements in the grid on the part that needs to be folded
                for ($y = ($axis ? $pos + 1 : 0); $y <= $height; $y++) {
                    for ($x = ($axis ? 0 : $pos + 1); $x <= $width; $x++) {
                        // if a coordinate is set on this piece of the fold
                        if (isset($grid[$y][$x])) {
                            // we move it to a new location on the opposite side of the fold
                            $grid[$axis ? $pos - ($y - $pos) : $y][$axis ? $x : $pos - ($x - $pos)] = true;
                            // and unset the element in this part of the fold
                            unset($grid[$y][$x]);
                        }
                    }
                }

                // reduce the height or width based on the folding position and the folding axis
                $height = $axis ? $pos : $height;
                $width = $axis ? $width : $pos;

                // only once, we need to determine the answer to part one of the assignment
                if ($active_coordinates_after_first_fold === null) {
                    // count all coordinates
                    $active_coordinates_after_first_fold = array_reduce($grid, function ($c, $row) {
                        return $c + count($row);
                    });
                }
            }
        }

        // draw grid
        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $drawn_grid .= isset($grid[$y][$x]) ? "#" : ".";
            }
            $drawn_grid .= "\n";
        }

        // return answers
        return
            [
                $active_coordinates_after_first_fold,
                $drawn_grid
            ];
    }
}