<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2022;

use jvwag\AdventOfCode\Assignment;
use jvwag\AdventOfCode\Year2018\Infi;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2022
 */
class Day12 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // use the input to find the width and height of the grid
        $max_x = strpos($this->getInput(), "\n");
        $max_y = substr_count($this->getInput(), "\n");

        // convert the input to one long string: there is no real need to store this in an x/y grid array
        $grid = str_replace("\n", "", $this->getInput());

        // find the start and end in the grid, and replace them with height values
        $grid[$start = strpos($grid, "S")] = "a";
        $grid[$end = strpos($grid, "E")] = "z";

        $nodes = [];
        // the grid id is a sequence number, mapping from the top, every row from left to right
        foreach (str_split($grid) as $id => $height) {
            // init a node, the node will contain an array with all other possible connections
            $nodes[$id] = [];

            // loop over all positions around the current position
            foreach ([[-1, 0], [0, 1], [1, 0], [0, -1]] as [$ny, $nx]) {
                // determine the x and y of our current index
                $y = intdiv($id, $max_x);
                $x = $id % $max_x;
                // determine the x and y of our neighbour, and from that the neighbouring id
                $nx += $x;
                $ny += $y;
                $nid = ($ny * $max_x) + $nx;
                // now check if the neighbour x,y coordinates is still in the grid
                // and compare the difference in height
                if ($ny < $max_y && $ny >= 0 && $nx < $max_x && $nx >= 0 && ord($grid[$nid]) - ord($height) <= 1) {
                    // add the new neighbour id to the list of peers for a node
                    $nodes[$id][] = $nid;
                }
            }
        }

        // calculate the shortest path from start to end given the nodes
        $non_scenic_route_length = $scenic_route_length = count(Infi::bfs_path($nodes, $start, $end)) - 1;

        // loop over the grid
        foreach (str_split($grid) as $id => $height) {
            // to find all grid positions with height 'a', and a possible path from there to the end
            if ($height === "a" && $route = Infi::bfs_path($nodes, $id, $end)) {
                // compare the route length and keep the lowest one
                $scenic_route_length = min([count($route) - 1, $scenic_route_length]);
            }
        }

        // return answers
        return
            [
                $non_scenic_route_length,
                $scenic_route_length
            ];
    }
}