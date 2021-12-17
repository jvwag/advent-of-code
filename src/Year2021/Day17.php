<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2021;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2021
 */
class Day17 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // get the area
        preg_match("/x=(-?\d+)\.\.(-?\d+), y=(-?\d+)\.\.(-?\d+)$/", trim($this->getInput()), $match);
        [, $min_x, $max_x, $min_y, $max_y] = array_map("intval", $match);

        $valid_vector_counter = $highest_y_position_of_valid_vector = 0;

        // set the number within to brute force
        $max = 500;

        // loop over all possible vectors
        for ($vector_x = 1; $vector_x < $max; $vector_x++) {
            for ($vector_y = -$max; $vector_y < $max; $vector_y++) {
                // init the variables and set the starting vector for this iteration
                $x = $y = $highest_y = 0;
                $v_x = $vector_x;
                $v_y = $vector_y;
                // step over the trajectory and check if we dit not overshoot our area
                while ($x < $max_x && $y > $min_y) {
                    // increment the x and y location
                    $x += $v_x;
                    $y += $v_y;

                    // save the highest y value we had this iteration
                    $highest_y = max($y, $highest_y);

                    // update the vector, reducing y by one, and getting x closer to zero each step
                    $v_y--;
                    $v_x = $v_x === 0 ? 0 : abs($v_x) - 1;

                    // check if we hit our area
                    if ($x >= $min_x && $x <= $max_x && $y >= $min_y && $y <= $max_y) {
                        // update the highest y position ever found (for assignment part one)
                        $highest_y_position_of_valid_vector = max($highest_y, $highest_y_position_of_valid_vector);
                        // increment the number of valid vectors found (for assignment part two)
                        $valid_vector_counter++;
                        break;
                    }
                }
            }
        }

        // return answers
        return
            [
                $highest_y_position_of_valid_vector,
                $valid_vector_counter
            ];
    }
}