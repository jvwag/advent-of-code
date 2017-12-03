<?php

namespace jvwag\AdventOfCode\Year2017;

use jvwag\AdventOfCode\Assignment;

/**
 * Class Day1
 *
 * @package jvwag\AdventOfCode\Year2017
 */
class Day1 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input to array of integers
        $data = array_map("\\intval", str_split(trim($this->getInput())));

        // init output
        $output1 = 0;
        $output2 = 0;

        // loop over all values
        $l = \count($data);
        for ($i = 0; $i < $l; $i++) {
            // determine if value is equal to previous value
            if ($data[$i] === $data[($l + $i - 1) % $l]) {
                $output1 += $data[$i];
            }
            // determine if value is equal to value half way round array
            if ($data[$i] === $data[($i + ($l / 2)) % $l]) {
                $output2 += $data[$i];
            }
        }

        // return answers
        return
            [
                $output1,
                $output2,
            ];
    }
}