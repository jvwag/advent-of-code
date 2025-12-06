<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2025;

use jvwag\AdventOfCode\Assignment;

class Day6 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // split all the lines and remove the last newline (but keep the spaces on the end)
        $lines = explode("\n", rtrim($this->getInput(), "\n"));

        // remove the last line from the set of lines, and match for operators and spaces, add one space to the last
        // set of operator/space combinations
        preg_match_all("/([*+])(\s+)/", array_pop($lines) . " ", $matches);
        // save the operators
        $operators = $matches[1];
        // save the number of spaces
        $column_lengths = array_map("strlen", $matches[2]);

        // initialize the matrices where we store the numbers for part1 and part2
        $part1_matrix = $part2_matrix = [];
        // loop over each line
        foreach ($lines as $line) {
            $offset = 0;
            // we split the line into columns using the column length in the last row
            foreach ($column_lengths as $i => $length) {
                // get a set of numbers
                $set = substr($line, $offset, $length);
                // set the new offset, add one for the column separator
                $offset += $length + 1;

                // for the first part we only need the complete set with numbers
                $part1_matrix[$i][] = trim($set);

                // for the second part we need to split the characters
                foreach (str_split(rtrim($set)) as $j => $char) {
                    // and add the number to a specific bucket of characters that will form the number
                    $part2_matrix[$i][$j] ??= "";
                    $part2_matrix[$i][$j] .= trim($char);
                }
            }
        }

        // return answers
        return
            [
                $this->calculateValues($part1_matrix, $operators),
                $this->calculateValues($part2_matrix, $operators),
            ];
    }

    function calculateValues($arr, $operators): int
    {
        $total = 0;
        // loop over all values
        foreach ($arr as $i => $group) {
            // based on the operator, take the sum or product of all values
            $total += match ($operators[$i]) {
                "+" => array_sum($group),
                "*" => array_product($group),
            };
        }
        return $total;
    }
}