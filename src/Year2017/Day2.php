<?php

namespace jvwag\AdventOfCode\Year2017;

use jvwag\AdventOfCode\Assignment;

/**
 * Class Day2
 *
 * @package jvwag\AdventOfCode\Year2017
 */
class Day2 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // create matrix from input
        $rows = \array_map(
            // split rows into columns
            function ($row) {
                // convert column values to int
                return \array_map(
                    "\\intval",
                    \preg_split("/\s+/", $row)
                );
            },
            // split input into rows
            \explode("\n", \trim($this->getInput()))
        );

        // init output
        $output1 = 0;
        $output2 = 0;

        // loop over all values
        foreach ($rows as $columns) {
            // add max minus min of a column to the first 'checksum'
            $output1 += \max($columns) - \min($columns);

            // loop over all permutations of two values in a column
            $l = \count($columns);
            for ($x = 0; $x < $l; $x++) {
                for ($y = $x + 1; $y < $l; $y++) {
                    $max = \max([$columns[$x], $columns[$y]]);
                    $min = \min([$columns[$x], $columns[$y]]);
                    // to determine if the two values can be divided with no remainders
                    if ($max % $min === 0) {
                        // and add the division to the second 'checksum'
                        $output2 += $max / $min;
                        break 2;
                    }
                }
            }
        }

        return
            [
                $output1,
                $output2,
            ];
    }
}