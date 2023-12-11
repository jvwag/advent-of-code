<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2023;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2023
 */
class Day11 extends Assignment
{
    public function run($expansion_for_part2 = 999999): array
    {
        // init variables
        $x = $y = 0;
        $galaxy_positions = [];

        // loop over input rows and columns
        foreach (explode("\n", trim($this->getInput())) as $y => $line) {
            foreach (str_split(trim($line)) as $x => $char) {
                // when the map contains a galaxy, store the position
                if ($char === "#") {
                    $galaxy_positions[] = [$x, $y];
                }
            }
        }

        // return answers
        return
            [
                $this->getSumOfGalaxyDistances($x, $y, $galaxy_positions, 1),
                $this->getSumOfGalaxyDistances($x, $y, $galaxy_positions, $expansion_for_part2)
            ];
    }

    public function getSumOfGalaxyDistances(int $max_x, int $max_y, array $galaxy_positions, int $expansion): int
    {
        // first determine the rows and columns in the map where there are no galaxies
        // create arrays with using the max, we only use the keys of the arrays later on
        $missing_columns = range(0, $max_x);
        $missing_rows = range(0, $max_y);
        foreach ($galaxy_positions as [$x, $y]) {
            if (in_array([$x, $y], $galaxy_positions, true)) {
                // unset all known entries, so we are left with the missing rows and columns
                unset($missing_columns[$y], $missing_rows[$x]);
            }
        }

        // loop over the rows and columns array (de-duplicating code with variable-variable names ;)
        // ugly, but just for fun :D
        foreach (["row", "column"] as $index => $type) {
            // loop over each missing row and column, we are going to add them
            foreach (array_values(${"missing_{$type}s"}) as $i => ${"missing_$type"}) {
                // loop over all galaxy positions to update the position given the amount we need to expand
                foreach ($galaxy_positions as &$p) {
                    // if a galaxy has a higher column or row value than we will move it based on the expansion size
                    // and the amount of times we have expanded before
                    if ($p[$index] > ${"missing_$type"} + ($i * $expansion)) {
                        $p[$index] += $expansion;
                    }
                }
            }
        }

        // as the last step we need to count the distance (manhattan distance) of all the galaxies between each other
        $c = count($galaxy_positions);
        $sum_of_distance = 0;
        // loop over all galaxy positions matching them twice
        for ($i = 0; $i < $c; $i++) {
            for ($j = $i + 1; $j < $c; $j++) {
                // add the distance to the sum
                $sum_of_distance +=
                    abs($galaxy_positions[$i][0] - $galaxy_positions[$j][0]) +
                    abs($galaxy_positions[$i][1] - $galaxy_positions[$j][1]);
            }
        }

        return $sum_of_distance;
    }
}