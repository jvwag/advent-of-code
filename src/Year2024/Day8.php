<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2024;

use jvwag\AdventOfCode\Assignment;

class Day8 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // init vars
        $antennas = $second_step_anti_nodes = $all_anti_nodes = [];

        // get all lines from input, and determine the size
        $lines = explode("\n", trim($this->getInput()));
        $max_y = count($lines);
        $max_x = strlen($lines[0]);

        // loop over all lines
        foreach ($lines as $y => $line) {
            // split the line and get all chars
            foreach (str_split($line) as $x => $frequency) {
                // if it is not an empty position
                if ($frequency !== ".") {
                    // add the position to the antenna array, indexed by the antenna frequency, with the coordinates in the grid
                    $antennas[$frequency][] = [$x, $y];
                }
            }
        }

        // loop over all antennas per frequency
        foreach ($antennas as $positions_per_frequency) {
            // match each antenna position of the frequency with all antenna positions of the same frequency
            foreach ($positions_per_frequency as [$source_x, $source_y]) {
                foreach ($positions_per_frequency as [$target_x, $target_y]) {
                    // skip the positions if they are equal
                    if ([$source_x, $source_y] === [$target_x, $target_y]) {
                        continue;
                    }

                    // determine the vector between the two positions
                    [$vector_x, $vector_y] = [$target_x - $source_x, $target_y - $source_y];

                    // now loop
                    $i = 0;
                    while (true) {
                        $i++;
                        // multiplying the vector for each step, calculating a new position
                        $calculated_x = $source_x + ($vector_x * $i);
                        $calculated_y = $source_y + ($vector_y * $i);

                        // if the new position is outside the grid, we stop processing
                        if ($calculated_x < 0 || $calculated_x >= $max_x || $calculated_y < 0 || $calculated_y >= $max_y) {
                            break;
                        }

                        // each valid new position is an 'antinode', we will store those in an array
                        $unique_key = "$calculated_x/$calculated_y";
                        // for part1 we only need the antinodes that are one 'hop' beyond the target antenna
                        if ($i == 2) {
                            $second_step_anti_nodes[$unique_key] = true;
                        }
                        // for part2 we need all positions the vector can give in the grid, including the
                        // target node
                        $all_anti_nodes[$unique_key] = true;
                    }
                }
            }
        }

        // return answers
        return
            [
                count($second_step_anti_nodes),
                count($all_anti_nodes)
            ];
    }
}