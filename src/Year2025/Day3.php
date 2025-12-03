<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2025;

use jvwag\AdventOfCode\Assignment;

class Day3 extends Assignment
{
    public function run(): array
    {
        // parse input: [[int,int,..],[int,int,..],..]
        $banks = array_map(function ($bank) {
            return array_map("intval", $bank);
        }, array_map("str_split", explode("\n", trim($this->getInput()))));

        // init output
        $output1 = $output2 = 0;
        // loop over each bank
        foreach ($banks as $bank) {
            // part one, find the first battery: the highest number of all numbers except the last
            $first = max(array_slice($bank, 0, -1));
            // find the second battery: the highest number of all numbers to the right of the first found number
            $second = max(array_slice($bank, array_search($first, $bank) + 1));
            // combine and add to answer
            $output1 += intval($first . $second);

            // part two
            $joltage = "";
            $pos = 0;
            // determine window to search for the first battery
            // the size of the window is the band size minus the max number of digits we are looking for, plus one
            $window_size = count($bank) - 12 + 1;
            // loop over the bank until we have found 12 batteries
            while (strlen($joltage) < 12) {
                // take a part (window) of the bank we will inspect
                $window = (array_slice($bank, $pos, $window_size));
                // determine the highest battery value in the window
                $battery = max($window);
                // now determine the position of this battery in the window
                $skip = array_search($battery, $window);
                // if it was not the first battery, we skipped some numbers...
                // the search window should be adjusted so
                $window_size -= $skip;
                // the next window we will start looking to the right of the number we just found
                $pos += $skip + 1;
                // add the found battery value to the joltage number
                $joltage .= $battery;
            }
            // add the joltage to the answer
            $output2 += intval($joltage);
        }

        // return answers
        return
            [
                $output1,
                $output2
            ];
    }
}