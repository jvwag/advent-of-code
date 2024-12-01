<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2024;

use jvwag\AdventOfCode\Assignment;

class Day1 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        foreach(explode("\n", $this->getInput()) as $line) {
            if(preg_match("/^(\d+)\s+(\d+)$/", $line, $matches)) {
                $first_list[] = $matches[1];
                $second_list[] = $matches[2];
            }
        }

        // sort both lists
        sort($first_list);
        sort($second_list);

        // count all the occurrences of values in the second list
        $second_list_count = array_count_values($second_list);

        // initialize output
        $output1 = $output2 = 0;

        // loop over the number of listed items
        $c = count($first_list);
        for($i = 0; $i < $c; $i++) {
            // part1: take the sum of the difference of both numbers (use abs to take the positive value)
            $output1 += abs($first_list[$i] - $second_list[$i]);
            // part2: take the sum of the product of the first list and the number of occurrences of that number in the second list
            $output2 += $first_list[$i] * ($second_list_count[$first_list[$i]] ?? 0);
        }

        // return answers
        return
            [
                $output1,
                $output2
            ];
    }
}