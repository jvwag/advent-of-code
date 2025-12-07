<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2025;

use jvwag\AdventOfCode\Assignment;

class Day7 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $lines = explode("\n", trim($this->getInput()));
        // create beam array
        $beam = array_fill(0, strlen($lines[0]), 0);
        // determine position of starting beam
        $beam[strpos(array_shift($lines), "S")] = 1;

        $output1 = 0;
        // loop over all lines
        foreach ($lines as $line) {
            // loop over all positions of the line
            foreach (str_split(trim($line)) as $pos => $char) {
                // if we find a splitter and there is also a beam
                if ($char === "^" && $beam[$pos] > 0) {
                    // increment the part1 answer: times a bream is split
                    $output1++;
                    // create new beams (the puzzle inputs seem to have enough space so no check for overflows is needed)
                    // instead of only a boolean that is required for part1, add the number of paths of a beam to the new
                    // beam positions. merging two beams will sum the values of the incoming beams
                    $beam[$pos - 1] += $beam[$pos];
                    $beam[$pos + 1] += $beam[$pos];
                    // and disable the beam at the splitter
                    $beam[$pos] = 0;
                }
            }
        }

        // return answers
        return
            [
                $output1,
                array_sum($beam) // sum of all possible paths
            ];
    }
}