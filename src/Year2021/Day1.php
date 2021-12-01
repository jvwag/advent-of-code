<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2021;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2021
 */
class Day1 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $depths = array_map("intval", explode("\n", $this->getInput()));

        // init output values
        $single_increments = 0;
        $sliding_window_increments = 0;

        // minus one, so we wont compare the last value
        $depth_count = count($depths) - 1;

        // loop over all values
        for ($i = 0; $i < $depth_count; $i++) {
            // compare the current depth to the next
            if ($depths[$i] < $depths[$i + 1]) {
                $single_increments++;
            }
            // compare the current depth to the third next depth, not comparing the overlapping depths
            // and with condition not to compare the last depth values which exceeds the numbers of depths
            if ($i < $depth_count - 2 && $depths[$i] < $depths[$i + 3]) {
                $sliding_window_increments++;
            }
        }

        // return answers
        return
            [
                $single_increments,
                $sliding_window_increments
            ];
    }
}