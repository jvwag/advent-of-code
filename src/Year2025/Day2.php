<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2025;

use jvwag\AdventOfCode\Assignment;

class Day2 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // parse input to ranges array with two elements: start and end
        $ranges = array_map(function ($x) {
            return explode("-", $x);
        }, explode(",", $this->getInput()));

        // init output
        $output1 = $output2 = 0;

        // loop over all ranger
        foreach ($ranges as [$start, $end]) {
            // loop over each number
            for ($i = $start; $i <= $end; $i++) {
                // convert the number to string and determine the length
                $i = (string)$i;
                $l = strlen($i);

                // part1: only use the numbers who split into two equal parts
                if ($l % 2 === 0) {
                    // split the two parts
                    $split = str_split($i, $l / 2);
                    // and compare the two parts
                    if ($split[0] === $split[1]) {
                        // if equal, add the value to the first answer
                        $output1 += intval($i);
                    }
                }

                // part2: loop over the possible sizes the number can be split into
                // start with the largest possible value first
                for($q = intdiv($l, 2); $q >= 1; $q--) {
                    // if the possible size fits the number of digits of the number
                    if($l % $q === 0) {
                        // split the number into equal parts
                        $split = str_split($i, $q);
                        // check if all values in the split are equal
                        if(count(array_flip($split)) === 1) {
                            // if all parts are equal, add it to the answer
                            $output2 += intval($i);
                            // only do this once for each number
                            break;
                        }
                    }
                }
            }
        }

        // return answers
        return
            [
                $output1,
                $output2
            ];
    }
}