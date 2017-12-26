<?php

namespace jvwag\AdventOfCode\Year2017;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2017
 */
class Day9 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // get the input
        $input = trim($this->getInput());

        // clean all cancel characters
        $input = $this->cleanCancels($input);

        // clean all garbage (and get the number of removed characters)
        $input = $this->cleanGarbage($input, $cleaned_garbage);

        // return answers
        return
            [
                $this->weighGroups($input), // weigh groups
                $cleaned_garbage // cleaned characters
            ];
    }

    /**
     * Remove every character after an exclamation mark
     *
     * @param string $string string to clean
     * @return string cleaned string
     */
    public function cleanCancels($string)
    {
        return (string)preg_replace("/!./", "", $string);
    }

    /**
     * Remove every 'garbage' section, starting with '<' and ending with '>'
     *
     * @param string $string string to clean
     * @param int $removed removed characters excluding the '<' and '>" chars
     * @return string cleaned string
     */
    public function cleanGarbage($string, &$removed = null)
    {
        // filter the garbage
        $output = (string)preg_replace("/<[^>]*>/", "", $string, -1, $c);

        // calculate number of removed chars by comparing input and output length and compensating for the control
        // characters by subtracting two for every occurrence of a garbage block
        $removed = strlen($string) - strlen($output) - ($c * 2);

        return $output;
    }

    /**
     * Count the number of groups, weigh it by depth and sum
     *
     * @param string $input
     * @return int Weight of groups
     */
    public function weighGroups($input)
    {
        $l = strlen($input);
        $v = $t = 0;
        // loop over the length of the string
        for ($i = 0; $i < $l; $i++) {
            // increment the value of a group weight for every group start
            if ($input[$i] === "{") {
                $v++;
            }
            // and on every group end, add the current value to the total
            if ($input[$i] === "}") {
                $t += $v;
                // and decrement the weight because we exited a group
                $v--;
            }
        }

        return $t; // return the total
    }
}