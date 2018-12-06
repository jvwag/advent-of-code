<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2018;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2018
 */
class Day6 extends Assignment
{
    private const MAX_DISTANCE = 10000;

    /** @var int Max Distance */
    private $max_distance = self::MAX_DISTANCE;

    /**
     * @return array
     */
    public function run(): array
    {
        // get input
        $input = $this->getInput();

        // parse input and create array of x,y coordinates
        $coordinates = [];
        foreach (explode("\n", trim($input)) as $line) {
            if (preg_match("/^(\d+)\s*,\s*(\d+)$/", $line, $match)) {
                $coordinates[] = [(int)$match[1], (int)$match[2]];
            }
        }

        // determine min and max x in coordinates array
        $x_list = array_column($coordinates, 0);
        $min_x = min($x_list) - 1;
        $max_x = max($x_list) + 1;

        // determine min and max y in coordinates array
        $y_list = array_column($coordinates, 1);
        $min_y = min($y_list) - 1;
        $max_y = max($y_list) + 1;

        // get the max distance (default 10000, but can me different for unit-tests)
        $max_distance = $this->getMaxDistance();

        // init vars
        $grid = [];
        $excluded = [];
        $count_total_distances_less_than_max = 0;

        // loop over complete grid
        for ($y = $min_y; $y < $max_y; $y++) {
            for ($x = $min_x; $x <= $max_x; $x++) {

                // init vars for this iteration
                $distances_per_coordinate = [];
                $distances_sum = 0;

                // calculate distance between grid location and all given coordinates
                foreach ($coordinates as [$loc_x, $loc_y]) {
                    // manhattan distance
                    $d = abs($x - $loc_x) + abs($y - $loc_y);

                    // store distance for each coordinate
                    $distances_per_coordinate[$loc_x . "x" . $loc_y] = $d;

                    // make sum of distances
                    $distances_sum += $d;
                }

                // if the sum of distances is more than the given maximum, add it to a total
                if ($distances_sum < $max_distance) {
                    $count_total_distances_less_than_max++;
                }

                // determine the minimal distance
                $minimal_distance = min($distances_per_coordinate);
                // and see if there is just one minimal distance
                if (array_count_values($distances_per_coordinate)[$minimal_distance] === 1) {
                    // find the closest coordinate, and add it to the grid
                    $grid[] = $closest_coordinate = array_search($minimal_distance, $distances_per_coordinate, true);

                    // if the closest_coordinate is on the outskirts of our grid, it must be infinite, so we
                    // mark the coordinate to be excluded later
                    if ($x === $min_x || $x === $max_x || $y === $min_y || $y === $max_y) {
                        $excluded[$closest_coordinate] = $closest_coordinate;
                    }
                }

            }
        }

        // remove excluded coordinate from grid
        $grid = array_diff($grid, $excluded);

        // determine which coordinate has the most occurrences in the grid
        $largest_area = max(array_count_values($grid));

        // return answers
        return
            [
                $largest_area,
                $count_total_distances_less_than_max
            ];
    }

    /**
     * @return int
     */
    public function getMaxDistance(): int
    {
        return $this->max_distance;
    }

    /**
     * @param int $max_distance
     */
    public function setMaxDistance(int $max_distance): void
    {
        $this->max_distance = $max_distance;
    }
}