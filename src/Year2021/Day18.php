<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2021;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2021
 */
class Day18 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $numbers = explode("\n", trim($this->getInput()));
        $count_of_numbers = count($numbers);

        // for the first part of the assignment we need add and reduce all the given numbers
        $magnitude_of_reduction_of_all_numbers =
            $this->calculate_magnitude(
                $this->add_and_reduce($numbers)
            );

        // for part two of the assignment we need to find the biggest magnitude given two of the given numbers
        $largest_magnitude_of_reduction_of_two_numbers = 0;

        // so we loop over all possible combination of two numbers
        for ($number1 = 0; $number1 < $count_of_numbers; $number1++) {
            for ($number2 = 0; $number2 < $count_of_numbers; $number2++) {
                // except if they are the same
                if ($number1 !== $number2) {
                    // get the maximum magnitude, when adding and reducing two of the numbers
                    $largest_magnitude_of_reduction_of_two_numbers = max(
                        $this->calculate_magnitude(
                            $this->add_and_reduce([$numbers[$number1], $numbers[$number2]])
                        ),
                        $largest_magnitude_of_reduction_of_two_numbers
                    );
                }
            }
        }

        // return answers
        return
            [
                $magnitude_of_reduction_of_all_numbers,
                $largest_magnitude_of_reduction_of_two_numbers
            ];
    }

    public function calculate_magnitude(string $input): int
    {
        // keep matching a pair "[x,y]" , from left to right
        while (preg_match("/\[(\d+),(\d+)]/", $input, $match)) {
            // replacing it with its magnitude calculation (3 * x + 3 * y)
            $input = preg_replace("/" . preg_quote($match[0]) . "/", (string)((3 * $match[1]) + (2 * $match[2])), $input, 1);
        }

        // the last value will have been replaced by a number, so convert it to an integer
        return (int)$input;
    }

    public function add_and_reduce(array $numbers): string
    {
        $output = null;

        // loop over all given numbers
        foreach ($numbers as $number) {
            // the first number will be the starting number
            if (!$output) {
                $output = $number;
            } else {
                // following numbers will be added to each other
                $output = "[" . $output . "," . $number . "]";

                // after the addition, we reduce the value
                $output = $this->reduce($output);
            }
        }

        return $output;
    }

    public function reduce(string $input): string
    {
        $prev_input = null;
        // loop over the input until it does not change anymore
        while ($prev_input !== $input) {
            $prev_input = $input;

            // try to explode values in the input
            $input = $this->explode($input);
            if ($prev_input !== $input) {
                // if we did, we will loop over to see if we can explode again
                continue;
            }

            // and try to split the input
            $input = $this->split($input);
        }

        // return the input if we can not reduce it any further
        return $input;
    }

    public function explode($input)
    {
        // init a depth value
        $depth = 0;
        // loop over each character in the input
        foreach (str_split($input) as $start_pos => $char) {
            // and count the number of brackets to determine the depth
            if ($char === "[") {
                $depth++;
            } elseif ($char === "]") {
                $depth--;
            }

            // if we find our self at a depth of more than four, and we match a pair of two integer numbers
            if ($depth > 4 && preg_match("/^\[(\d+),(\d+)]/", substr($input, $start_pos), $match)) {

                // extract the values from the pair, and convert them to integers
                [, $value_left, $value_right] = array_map("intval", $match);

                // replace the pair of numbers with a '0' character
                $input = substr_replace($input, "0", $start_pos, strlen($match[0]));

                // find a number before the position in the string we have matched
                if (preg_match("/(\d+)([\[\],]+)$/", substr($input, 0, $start_pos), $match)) {
                    // replace that number we found with the sum of its original number and the left part of the pair
                    $input = substr_replace(
                        $input,
                        // the new value we want to insert
                        (string)(intval($match[1]) + $value_left),
                        // the position were we need to replace is the starting position
                        // minus the length of the value we matched,
                        // minus the length of the characters between the starting position and the value
                        $start_pos - (strlen($match[1]) + strlen($match[2])),
                        // replace the length of characters we originally found to the left
                        strlen($match[1])
                    );

                    // because we will use the starting position again to find a number to the right
                    // we update the starting position with the difference in length between the originally found
                    // value and the newly inserted value... the newly inserted value could have made the string
                    // a bit longer...
                    $start_pos += strlen((string)(intval($match[1]) + $value_left)) - strlen($match[1]);
                }

                // we do the same finding a number to the left of the found pair
                if (preg_match("/^([\[\],]+)(\d+)/", substr($input, $start_pos + 1), $match)) {
                    $input = substr_replace(
                        $input,
                        // the new value we will insert
                        (string)(intval($match[2]) + $value_right),
                        // the starting position is the number of characters between the pair and the first number, but
                        // plus one because we will also count the inserted '0' character
                        $start_pos + strlen($match[1]) + 1,
                        // and the length of the matched original character
                        strlen($match[2])
                    );
                }

                // if we have done a replacement, we will break the loop
                break;
            }
        }

        // return the given, or updated input
        return $input;
    }

    public function split($input)
    {
        // find the first occurrence of a number with double digits (same as > 9)
        if (preg_match("/(\d\d+)/", $input, $match)) {
            // replace these double digits (by finding them again
            $input = preg_replace(
                "/(\d\d+)/",
                // with a pair, divided by two, with the remainder in the second value
                "[" . floor($match[1] / 2) . "," . ceil($match[1] / 2) . "]",
                // in the input
                $input,
                // but only one (the first)
                1);
        }

        // return the given, or updated input
        return $input;
    }
}