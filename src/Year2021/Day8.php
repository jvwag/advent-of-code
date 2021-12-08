<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2021;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2021
 */
class Day8 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // init output values
        $sum_of_all_outputs = 0;
        $number_of_1_4_7_8_in_output = 0;

        // loop over all input lines
        foreach (explode("\n", trim($this->getInput())) as $line) {

            // first we start filling the pattern array
            $target_array = "pattern";

            // init the arrays we will fill
            $pattern = $output = $decode = [];

            // loop over each segment pattern
            foreach (explode(" ", trim($line)) as $element) {
                // if we find a separator character
                if ($element === "|") {
                    // we switch the target array to output
                    $target_array = "output";
                } else {
                    // split the pattern in an array and sort all elements
                    $sort = str_split($element);
                    sort($sort);
                    // assign it to the pattern or output array
                    ${$target_array}[] = $sort;
                }

                // for part one we will need to count the number of 1's, 4's, 7's and 8's
                // but only in the output array, we match by their pattern length
                if ($target_array === "output" && in_array(strlen($element), [2, 3, 4, 7])) {
                    $number_of_1_4_7_8_in_output++;
                }
            }

            // specific patterns with a fixed length are tied to specific numbers
            foreach ([8 => 7, 1 => 2, 7 => 3, 4 => 4] as $num => $length) {
                // loop over all patterns
                foreach ($pattern as $element) {
                    // and if it matches a length
                    if (count($element) === $length) {
                        // set the decoded pattern
                        $decode[$num] = $element;
                    }
                }
            }

            // loop over all patterns to match to defined rules
            foreach ($pattern as $element) {
                // but only elements we have not decoded yet
                if (!in_array($element, $decode)) {
                    // we match a '3' pattern by counting five segments and have the same active segments as a '1'
                    if (count($element) === 5 && count(array_diff($decode[1], $element)) === 0) {
                        $decode[3] = $element;
                    } elseif (count($element) === 6) {
                        // and now for two patterns with six active segments

                        // a '6' can be matched if only one active segments matches to a '1'
                        if (count(array_diff($decode[1], $element)) === 1) {
                            $decode[6] = $element;
                        } elseif (count(array_diff($decode[4], $element)) === 1) {
                            // and a '0' is matched if it has all but one segments equal to a '4'
                            $decode[0] = $element;
                        } elseif (count(array_diff($decode[4], $element)) === 0) {
                            // and a '9' is matched if it has all the same segments active compared to a '4'
                            $decode[9] = $element;
                        }
                    }
                }
            }

            // for the next test we need to determine the location that is present in a '8' but not in a '9'
            $diff_8_9 = array_diff($decode[8], $decode[9]);
            $diff_8_9 = array_pop($diff_8_9);

            // again loop over all patterns
            foreach ($pattern as $element) {
                // and only process patterns with a length of five and not already processed
                if (count($element) === 5 && !in_array($element, $decode))
                    // if the element has the specific segment set, it's a '2'
                    if (in_array($diff_8_9, $element)) {
                        $decode[2] = $element;
                    } else {
                        // and in the other case the remaining value is a '5'
                        $decode[5] = $element;
                    }
            }

            // now we have a complete coding table, we will decode the output segments to a number
            $number = "";

            // loop over all output values
            foreach ($output as $element) {
                // lookup a pattern in the decoded patterns array
                foreach ($decode as $k => $d) {
                    // if the segment matches the decoded segment pattern
                    if ($d === $element) {
                        // add the number
                        $number .= $k;
                    }
                }
            }

            // add the number to the
            $sum_of_all_outputs += (int)$number;
        }

        // return answers
        return
            [
                $number_of_1_4_7_8_in_output,
                $sum_of_all_outputs
            ];
    }
}