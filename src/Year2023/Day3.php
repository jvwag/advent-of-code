<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2023;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2023
 */
class Day3 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // init output vars, location lists, and a gear list
        $sum_of_all_part_numbers = $sum_of_gear_ratios = 0;
        $number_locations = $symbol_locations = $gear_locations = $gear_list = [];

        // loop over all lines
        foreach (explode("\n", $this->getInput()) as $y => $line) {
            // set the initial number to empty
            $number = "";
            // loop over all characters
            foreach (str_split(trim($line)) as $x => $char) {
                // if we have found a number
                if (is_numeric($char)) {
                    // add the number to the list
                    $number .= $char;
                } else {
                    // if we have found no number, but we have started filling the number
                    if ($number !== "") {
                        // we add the number to the list, with the x,y value of its last digit
                        $number_locations[] = [$number, $x, $y];
                        // rinse and repeat
                        $number = "";
                    }
                    // build an array of symbol locations
                    if ($char !== ".") {
                        $symbol_locations[] = [$x, $y];
                    }
                    // build an array of gear locations
                    if ($char === "*") {
                        $gear_locations[] = [$x, $y];
                    }
                }

            }
            // if we are at the end of the line, if we were are still constructing a number, add it to the list
            if ($number !== "") {
                $number_locations[] = [$number, $x, $y];
            }
        }

        // now we start looping over all the numbers we have found
        foreach ($number_locations as [$number, $last_x, $y]) {
            // set the adjacent flags to false
            $adjacent_gear = $adjacent_symbol = false;
            // loop over each character in the number, calculating the x/y position based on the last character
            for ($x = $last_x - strlen($number); $x < $last_x; $x++) {
                // loop over each surrounding character of a number character
                foreach ([[-1, -1], [-1, 0], [-1, 1], [0, 1], [1, 1], [1, 0], [1, -1], [0, -1]] as [$offset_x, $offset_y]) {
                    $x_bis = $x + $offset_x;
                    $y_bis = $y + $offset_y;

                    // is the number character close to a symbol?
                    if (in_array([$x_bis, $y_bis], $symbol_locations)) {
                        $adjacent_symbol = true;
                    }
                    // is the number character close to a gear '*'?
                    if (in_array([$x_bis, $y_bis], $gear_locations)) {
                        // we take the location of the gear to create a unique key
                        $adjacent_gear = $x_bis . "/" . $y_bis;
                    }
                    // early opt out if we have found both a symbol and a gear
                    if ($adjacent_symbol && $adjacent_gear) {
                        break;
                    }
                }
            }

            // if we have found that the number is adjacent to a gear
            if ($adjacent_gear) {
                // add it to a gear list, adding the number to a specific gear we found
                $gear_list[$adjacent_gear][] = intval($number);
            }

            // if we have found that the number is adjacent to a symbol
            if ($adjacent_symbol) {
                // add the part number to the sum
                $sum_of_all_part_numbers += intval($number);
            }
        }

        // we loop over all the gears we have found with adjacent numbers
        foreach ($gear_list as $gear_values) {
            // if there are exactly two numbers on a gear
            if (count($gear_values) === 2) {
                // we take the product of the two numbers as a gear ratio, and add it to the gear ratio sum
                $sum_of_gear_ratios += array_product($gear_values);
            }
        }

        // return answers
        return
            [
                $sum_of_all_part_numbers,
                $sum_of_gear_ratios
            ];
    }
}