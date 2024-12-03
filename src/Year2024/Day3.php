<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2024;

use jvwag\AdventOfCode\Assignment;

class Day3 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert the input to one big line (this helps for part2, as we need to keep the state
        // of the on/off switch across lines
        $line = str_replace("\n", "", trim($this->getInput()));

        // return answers
        return
            [
                // calculate the sum of all mul(x,y) instructions
                $this->calculateSumOfMulInstructions($line),
                // same, but remove all parts from "don't()" to "do()"
                $this->calculateSumOfMulInstructions(preg_replace("/don't\(\).*?(do\(\)|$)/", "", $line))
            ];
    }

    public function calculateSumOfMulInstructions($line): int
    {
        $sum = 0;
        // find all mul(x,y) instruction in line
        if (preg_match_all("/mul\((\d+),(\d+)\)/", $line, $match)) {
            // loop over all found instructions
            for ($i = 0; $i < count($match[0]); $i++) {
                // multiply the x and y value, and add it to the sum
                $sum += intval($match[1][$i]) * intval($match[2][$i]);
            }
        }
        // return the sum
        return $sum;
    }
}