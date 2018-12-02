<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2018;

use jvwag\AdventOfCode\Assignment;

/**
 * Class Day2
 *
 * @package jvwag\AdventOfCode\Year2018
 */
class Day2 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        /** @noinspection PhpUnusedLocalVariableInspection */
        $input = $this->getInput();

        // init vars
        $output2 = null;
        $two_chars_count = 0;
        $three_chars_count = 0;

        // split the lines by newline and determine number of lines
        $lines = explode("\n", trim($input));
        $line_count = count($lines);

        // loop over all lines
        for ($p = 0; $p < $line_count; $p++) {
            // make an array of occurrences of each char used in the string a
            $found_chars = count_chars($lines[$p], 1);

            // add counter for a string that has two same chars
            if (in_array(2, $found_chars, true)) {
                $two_chars_count++;
            }

            // add counter for a string that has three same chars
            if (in_array(3, $found_chars, true)) {
                $three_chars_count++;
            }

            // if we have not found the part 2 answer
            if ($output2 === null) {
                // loop over all lines following this line
                for ($q = $p + 1; $q < $line_count; $q++) {
                    // convert strings to array and calculate diff between two arrays
                    $diff = array_diff_assoc(str_split($lines[$p]), str_split($lines[$q]));
                    // if the diff has only one change (one char) it must be the answer
                    if (count($diff) === 1) {
                        // the position of the char is the key of the only element in the diff
                        $pos = key($diff);

                        // remove the diff char from the string and use it as the answer
                        $output2 = substr($lines[$p], 0, $pos) . substr($lines[$p], $pos + 1);
                    }
                }
            }
        }

        // the solution of the first part is the product of the strings with two and three same chars
        $output1 = $two_chars_count * $three_chars_count;

        // return answers
        return
            [
                $output1,
                $output2
            ];
    }
}