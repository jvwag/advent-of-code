<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2021;

// a bit more memory is needed for pathfinding
ini_set("memory_limit", "1G");

use jvwag\AdventOfCode\Assignment;

// and we use the A* path-finding algorithm by Jose (jmgq)
// https://github.com/jmgq/php-a-star
use JMGQ\AStar\AStar;
use JMGQ\AStar\DomainLogicInterface;


/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2021
 */
class Day15 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // parse input and convert to grid with grid[y][x] coordinates and the weight as value
        $grid = array_map(function ($a) {
            return array_map("intval", str_split($a));
        }, explode("\n", trim($this->getInput())));

        // store the initial grid, to calculate part one of the assignment later
        $initial_grid = $grid;

        // get grid size
        $width = count($grid[0]);
        $height = count($grid);
        // and loop 5 times for x and y
        for ($x_block = 0; $x_block < 5; $x_block++) {
            for ($y_block = 0; $y_block < 5; $y_block++) {
                // if we are not processing the initial (top left) block
                if ($y_block !== 0 || $x_block !== 0) {
                    // loop over every element in the initial block
                    for ($x = 0; $x < $width; $x++) {
                        for ($y = 0; $y < $height; $y++) {
                            // get the current value from the initial block
                            $value = $grid[$y][$x] + $x_block + $y_block;

                            // if the value is higher than nine, reset and count from one
                            if ($value > 9) {
                                $value = 1 + ($value - 10);
                            }

                            // store the new value in the grid based on a y and x block offset
                            $grid[$y + ($y_block * $height)][$x + ($x_block * $width)] = $value;
                        }
                    }
                }
            }
        }

        // return answers
        return
            [
                $this->traverse_grid($initial_grid),
                $this->traverse_grid($grid) // the last grid is resized
            ];
    }

    /**
     * @param int[][] $grid Grid of weights given in an array keyed by [y][x]
     * @return int The total path cost excluding the first value
     */
    private function traverse_grid(array $grid): int
    {
        // determine width and height based on the given grid
        $width = count($grid[0]);
        $height = count($grid);

        // loop over the grid to determine the nodes
        $nodes = [];
        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                // only look up, down, left and right
                foreach ([[-1, 0], [0, -1], [1, 0], [0, 1]] as [$x_offset, $y_offset]) {
                    // but only if a grid element exists
                    if (isset($grid[$y + $y_offset][$x + $x_offset])) {
                        // create per node an array of adjacent nodes with a weight
                        $nodes[$x . "/" . $y][($x + $x_offset) . "/" . ($y + $y_offset)] = $grid[$y + $y_offset][$x + $x_offset];
                    }
                }
            }
        }

        // the created array with nodes will be put into an A* solver by Jose (jmgq)
        $solution = (new AStar(
            // it needs a specific interface to connect to the data
            new class ($nodes) implements DomainLogicInterface {
                public function __construct(public array $nodes)
                {
                }

                public function getAdjacentNodes(mixed $node): iterable
                {
                    return array_keys($this->nodes[$node]);
                }

                public function calculateRealCost(mixed $node, mixed $adjacent): float|int
                {
                    return $this->nodes[$node][$adjacent];
                }

                public function calculateEstimatedCost(mixed $fromNode, mixed $toNode): float|int
                {
                    return 0;
                }
            }
            // run the solver from start 0/0 to last element in the lower right corner
        ))->run("0/0", ($width - 1) . "/" . ($height - 1));

        // the solver also gives the first node's weight, we do not need that for this solution, so we remove this
        array_shift($solution);

        // now create a sum of the weights... the solver only gives a path, so we parse each step and lookup the weight
        $sum = 0;
        foreach ($solution as $step) {
            [$x, $y] = explode("/", $step);
            // and sum each weight
            $sum += $grid[$y][$x];
        }

        // return the sum of the path
        return $sum;
    }
}