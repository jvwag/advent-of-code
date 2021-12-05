<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2021;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2021
 */
class Day5 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // init grid arrays
        $grid_without_diagonal_vectors = $grid_with_all_vectors = [];

        // loop over all input lines
        foreach (explode("\n", trim($this->getInput())) as $line) {
            // extract vector from each line
            if (preg_match("/^(\d+),(\d+) -> (\d+),(\d+)$/", trim($line), $match)) {
                // convert values to ints
                [, $x1, $y1, $x2, $y2] = array_map("intval", $match);

                // determine direction of axis (1 and -1 will be increment or decrement, and 0 will be the same
                // start and end value on the axis
                $x_direction = $x2 <=> $x1;
                $y_direction = $y2 <=> $y1;

                // loop over every step from the vector, using the direction to increment, decrement or stay the same every step
                // the test value of the ending adds one direction point to make sure we also process the last step and
                // do not exit early
                for ($x = $x1, $y = $y1; !($x === $x2 + $x_direction && $y === $y2 + $y_direction); $x += $x_direction, $y += $y_direction) {

                    // the special case for the first part of the assignment, only horizontal and vertical vectors
                    if ($x1 === $x2 || $y1 === $y2) {
                        // increment a counter for every point on the grid we pass
                        // some nasty boiler plating because we did not initialize the full grid with zero's to keep memory consumption down
                        $grid_without_diagonal_vectors[$x . "/" . $y] = ($grid_without_diagonal_vectors[$x . "/" . $y] ?? 0) + 1;
                    }

                    // same type of grid increment, but now for all (including diagonal) vectors
                    $grid_with_all_vectors[$x . "/" . $y] = ($grid_with_all_vectors[$x . "/" . $y] ?? 0) + 1;
                }
            }
        }

        // a small lambda to count the number of elements in an array with a value higher than 1
        $f = function ($carry, $value) {
            return $carry + (int)($value > 1);
        };

        // return answers
        return
            [
                array_reduce($grid_without_diagonal_vectors, $f),
                array_reduce($grid_with_all_vectors, $f)
            ];
    }
}