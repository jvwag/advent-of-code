<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2021;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2021
 */
class Day20 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // split the input in a lookup table and a grid
        [$lookup_table, $grid] = explode("\n\n", trim($this->getInput()));

        // parse the lookup table and grid to arrays
        $lookup_table = str_split(trim($lookup_table));
        $grid = array_map("str_split", explode("\n", trim($grid)));

        // get the size of the grid
        $min_x = $min_y = 0;
        $max_x = count($grid[0]);
        $max_y = count($grid);

        // init the answers
        $pixels_of_the_last_image = 0;
        $pixels_after_two_passes = 0;

        // the universe is made of empty space, but a translation table could tell us otherwise
        $infinite_pixel_type = ".";

        // loop 50 times for the second part of the assignment
        for ($pass = 0; $pass < 50; $pass++) {

            // on the second pass, take a snapshot of the number of lid pixels
            if ($pass === 2) {
                $pixels_after_two_passes = $pixels_of_the_last_image;
            }

            // create a new grid each pass
            $new_grid = [];

            // increment the size of the grid by one
            $min_y--;
            $min_x--;
            $max_y++;
            $max_x++;

            // loop over every position in the known grid
            for ($y = $min_y; $y <= $max_y; $y++) {
                for ($x = $min_x; $x <= $max_x; $x++) {
                    $str = "";
                    // look at all adjacent positions
                    foreach ([[-1, -1], [-1, 0], [-1, 1], [0, -1], [0, 0], [0, 1], [1, -1], [1, 0], [1, 1]] as $vector) {
                        // get the value of the adjacent position
                        // if the value does not exist, we assume the type of pixel that is currently the infinite pixel
                        $str .= ($grid[$y + $vector[0]][$x + $vector[1]] ?? $infinite_pixel_type) === "#" ? "1" : "0";
                    }
                    // update the new grid
                    $new_grid[$y][$x] = $lookup_table[bindec($str)];
                }
            }

            // the new grid overwrites the old grid
            $grid = $new_grid;

            // calculate the number of lid pixels in our known part
            // (we assume we only will use this answer when the infinite image is not infinitely lid, because that
            // is quite a lot more than we will count here... even close to an infinite amount of lid pixels :)
            $pixels_of_the_last_image = array_reduce($grid, function ($carry, $row) {
                return $carry + array_reduce($row, function ($carry, $element) {
                        return $carry + (int)($element === "#");
                    });
            });

            // in the strange case (probably all puzzle input) the infinite pixel type is empty,
            // but the lookup table tells us all empty pixel combinations should be lid
            if ($infinite_pixel_type === "." && $lookup_table[0] === "#") {
                $infinite_pixel_type = "#"; // light up the rest of the infinite image
            } elseif($infinite_pixel_type === "#" && $lookup_table[count($lookup_table) - 1] === ".") {
                // the reverse is also true: if all pixels are lid, but the lookup table tells us
                // all lid pixels must be dark, turn of the infinite lights
                $infinite_pixel_type = ".";
            }
        }

        // return answers
        return
            [
                $pixels_after_two_passes,
                $pixels_of_the_last_image,
            ];
    }
}