<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2022;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2022
 */
class Day8 extends Assignment
{
    public function run(): array
    {
        // convert input to a y,x array with tree-height as value
        $tree_grid = array_map(function ($a) {
            return array_map("intval", str_split($a));
        }, explode("\n", trim($this->getInput())));

        // initialize data arrays and grid size
        $max_y = count($tree_grid);
        $max_x = count($tree_grid[0]);
        $viewable_trees = $treehouse_scenic_scores = [];

        // loop over all possible points in the grid
        for ($y = 0; $y < $max_y; $y++) {
            for ($x = 0; $x < $max_x; $x++) {
                $direction_scores = [];
                // for each point, look in all four directions
                foreach ([["y", -1], ["y", 1], ["x", -1], ["x", 1]] as [$axis, $direction]) {
                    // a view will be the list of trees from the current point to all edges
                    $view = [];
                    // loop to the edge given the axis and direction
                    if ($axis === "y") {
                        // loop to edge vertical, direction will indicate up or down
                        for ($test_y = $y + $direction; $test_y >= 0 && $test_y < $max_y; $test_y += $direction) {
                            // add all the trees in the path to the view list
                            $view[] = $tree_grid[$test_y][$x];
                        }
                    } elseif ($axis === "x") {
                        // loop to edge horizontal
                        for ($test_x = $x + $direction; $test_x >= 0 && $test_x < $max_x; $test_x += $direction) {
                            $view[] = $tree_grid[$y][$test_x];
                        }
                    }

                    // check if the view: if the view list is empty the view to the edge is unobstructed
                    // and if largest value on the list is larger than the current height of the tree
                    if (count($view) === 0 || max($view) < $tree_grid[$y][$x]) {
                        // create a list of trees that are viewable from the outside, and create a unique key
                        // because a tree can have unobstructed view to the edge in multiple directions
                        $viewable_trees["$y/$x"] = [$y, $x];
                    }

                    // now create a score for the direction
                    $direction_score = 0;
                    // loop over the view (list of trees in the view)
                    foreach ($view as $step) {
                        // and increase the score for every tree that can be seen
                        $direction_score++;
                        // but stop if we find a tree that is equal or higher than we are currently planning the treehouse
                        if ($step >= $tree_grid[$y][$x]) {
                            break;
                        }
                    }
                    // add the direction score to a list, so we can combine it for all four directions
                    $direction_scores[] = $direction_score;
                }
                // combine the scenic scores for every direction by multiplying them
                $treehouse_scenic_scores[] = array_product($direction_scores);
            }
        }

        // return answers
        return
            [
                // part one requires the number of viewable trees
                count($viewable_trees),
                // and the second part the score of the best scenic score for the treehouse
                max($treehouse_scenic_scores)
            ];
    }
}