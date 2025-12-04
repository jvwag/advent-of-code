<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2025;

use jvwag\AdventOfCode\Assignment;

class Day4 extends Assignment
{
    private const ADJACENT_VECTORS = [[-1, -1], [-1, 0], [-1, 1], [0, 1], [1, 1], [1, 0], [1, -1], [0, -1]];
    private const MAX_ROLLS = 4;
    /**
     * @return array
     */
    public function run(): array
    {
        // parse input and convert to grid[y][x]=bool
        $grid = array_map(function ($row) {
            return array_map(function ($column) {
                return $column === "@";
            }, str_split($row));
        }, explode("\n", trim($this->getInput())));

        // init answer values
        $moved_rolls_first_pass = $all_possible_movable_rolls = 0;

        // make passes until there is no roll to be moved (the roll counters stays the same)
        $previous_roll_counter = -1;
        while ($previous_roll_counter !== $all_possible_movable_rolls) {
            $previous_roll_counter = $all_possible_movable_rolls;

            // make a copy of the grid, so adjustments will not be used while still parsing the current pass
            $new_grid = $grid;

            // loop over all positions in the grid
            foreach ($grid as $y => $row) {
                foreach ($row as $x => $pos) {
                    // if the position contains a roll
                    if ($pos === true) {
                        // init counter for adjacent roll count
                        $c = 0;
                        // loop over all 8 positions around the current roll
                        foreach (self::ADJACENT_VECTORS as [$x_offset, $y_offset]) {
                            // check if the position exists, and the position has a roll
                            if (isset($grid[$y + $y_offset][$x + $x_offset]) && $grid[$y + $y_offset][$x + $x_offset] === true) {
                                // count that there is a roll
                                $c++;
                                // optimization: stop counting if we have seen enough rolls to determine it is blocked in
                                if($c >= self::MAX_ROLLS) {
                                    break;
                                }
                            }
                        }
                        // if after counting we have determined there are fewer than 4 rolls
                        if ($c < self::MAX_ROLLS) {
                            // check if we are in the first pass, so the first pass counter is not incremented in later passes
                            if ($previous_roll_counter === 0) {
                                // increment counter for part1
                                $moved_rolls_first_pass++;
                            }
                            // increment counter for part2
                            $all_possible_movable_rolls++;
                            // and remove the roll from the copy of the grid
                            $new_grid[$y][$x] = false;
                        }
                    }
                }
            }
            // use the adjusted grid
            $grid = $new_grid;
        }

        // return answers
        return
            [
                $moved_rolls_first_pass,
                $all_possible_movable_rolls
            ];
    }
}