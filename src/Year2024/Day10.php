<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2024;

use jvwag\AdventOfCode\Assignment;

class Day10 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // parse input to grid[y,x]
        $grid = [];
        foreach (explode("\n", trim($this->getInput())) as $line) {
            $grid[] = array_map("intval", str_split(trim($line)));
        }

        // init output vars
        $sum_of_unique_trailheads = $sum_of_possible_routes = 0;
        // loop over all places on the grid
        foreach($grid as $y => $row) {
            foreach($row as $x => $height) {
                // only for height values 0, we will start walking
                if($height === 0) {
                    // all possible routes to a tailhead
                    $tailheads_found = $this->walkAllPossibleRoutesToTrailheads($grid, $y, $x);
                    // for part1 we need the unique trailheads
                    $sum_of_unique_trailheads += count(array_unique($tailheads_found));
                    // for part2 we need the number of possible routes to all trailheads...
                    $sum_of_possible_routes += count($tailheads_found);
                }
            }
        }

        // return answers
        return
            [
                $sum_of_unique_trailheads,
                $sum_of_possible_routes
            ];
    }

    private function walkAllPossibleRoutesToTrailheads(array $grid, int $y, int $x): array
    {
        // if we have arrived at a trailhead, return the coordinate
        if ($grid[$y][$x] === 9) {
            return ["$x/$y"];
        }

        // loop over all possible directions and generate a next step y and x coordinate
        $trailheads_found = [];
        foreach ([[$y, $x + 1], [$y + 1, $x], [$y, $x - 1], [$y - 1, $x]] as [$next_y, $next_x]) {
            // if the coordinate exist in the grid, and the height value is exactly one step higher
            if (isset($grid[$next_y][$next_x]) && $grid[$next_y][$next_x] - $grid[$y][$x] === 1) {
                // walk this route from this new position... merging all trailheads we found
                $trailheads_found = array_merge($trailheads_found, $this->walkAllPossibleRoutesToTrailheads($grid, $next_y, $next_x));
            }
        }
        // return a list with all trailheads, if a trailhead has multiple routes it will return the same coordinate multiple times
        return $trailheads_found;
    }
}