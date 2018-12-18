<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2018;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2018
 */
class Day18 extends Assignment
{
    /** @var string Tree character */
    private const TREE = "|";

    /** @var string Yard character */
    private const YARD = "#";

    /** @var string Open character */
    private const OPEN = ".";

    /** @var int Steps to complete part one */
    private const STEPS_PART_1 = 10;

    /** @var int Steps to complete part two */
    private const STEPS_PART_2 = 1000000000;

    /**
     * @return array
     */
    public function run(): array
    {
        // convert input to grid (y,x)
        $grid = array_map("str_split", explode("\n", trim($this->getInput())));

        // array of previous grid states
        $previous_grid_states = [];

        // grid of part one
        $part_one_grid = [];

        // loop until we have reached the step count of part two
        for ($i = 0; $i < self::STEPS_PART_2; $i++) {

            // step the grid
            $grid = $this->step($grid);

            // if we have reached step 10, save the grid for the part one solution
            if ($i === self::STEPS_PART_1 - 1) {
                $part_one_grid = $grid;
            }

            // if we have found the first step where the grid is completely the same as a previous step
            // we will only repeat for now, so step as may times in the future for the difference between
            // our current step and the previous step number, but before the one billion mark
            if (($prev_step = array_search($grid, $previous_grid_states, true)) !== false) {
                $i = (floor((self::STEPS_PART_2 - $i) / ($i - $prev_step)) * ($i - $prev_step)) + $i;
            }

            // store our grid, to compare with previous steps
            $previous_grid_states[] = $grid;
        }

        // count tree's, yard's and empty spaces
        $count_values_part1 = array_count_values(array_merge(...$part_one_grid));
        $count_values_part2 = array_count_values(array_merge(...$grid));

        // return answers
        return
            [
                ($count_values_part1[self::TREE] ?? 0) * ($count_values_part1[self::YARD] ?? 0),
                ($count_values_part2[self::TREE] ?? 0) * ($count_values_part2[self::YARD] ?? 0),
            ];
    }

    /**
     * Stepping the grid makes the grid go one step forward in evolution
     *
     * @param string[][] $grid Array(y,x) grid of plot types (|: trees, #: lumberyard, .: empty)
     * @return string[][] The input grid array, but evolved one step
     */
    public function step($grid): array
    {
        $new_grid = [];

        // loop over all items in grid
        foreach ($grid as $y => $rows) {
            foreach ($rows as $x => $char) {
                // create array with all adjacent plots
                $arr = [
                    $grid[$y + 0][$x - 1] ?? " ",
                    $grid[$y + 1][$x - 1] ?? " ",
                    $grid[$y + 1][$x + 0] ?? " ",
                    $grid[$y + 1][$x + 1] ?? " ",
                    $grid[$y + 0][$x + 1] ?? " ",
                    $grid[$y - 1][$x + 1] ?? " ",
                    $grid[$y - 1][$x + 0] ?? " ",
                    $grid[$y - 1][$x - 1] ?? " ",
                ];
                // count the number of types in the plots
                $count = array_count_values($arr);

                // decision 'tree' ... lol
                if ($char === self::OPEN && ($count[self::TREE] ?? 0) > 2) {
                    // if we are on an open plot, and we have more than two tree plots adjacent, it becomes a tree
                    $new_grid[$y][$x] = self::TREE;
                } elseif ($char === self::TREE && ($count[self::YARD] ?? 0) > 2) {
                    // if we are on a tree plot, and we have more than two lumberyards adjacent, it becomes a yard
                    $new_grid[$y][$x] = self::YARD;
                } elseif ($char === self::YARD) {
                    // if we are on a yard plot, and we have at least one other yard and a tree plot adjacent, then we stay to be a yard
                    if (($count[self::YARD] ?? 0) > 0 && ($count[self::TREE] ?? 0) > 0) {
                        $new_grid[$y][$x] = self::YARD;
                    } else {
                        // but otherwise, we will remove the wood and become an open plot
                        $new_grid[$y][$x] = self::OPEN;
                    }
                } else {
                    // in all other cases the plot stays the same
                    $new_grid[$y][$x] = $char;
                }
            }
        }

        // return the new grid
        return $new_grid;
    }
}