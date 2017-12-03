<?php

namespace jvwag\AdventOfCode\Year2016;

use jvwag\AdventOfCode\Assignment;

/**
 * Class Day1
 *
 * @package jvwag\AdventOfCode\Year2016
 */
class Day1 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        $data = $this->getInput();

        $x = 0;
        $y = 0;
        $d = 0;
        $first_crossing = false;
        $visited_blocks = [];

        // Parse all locations
        preg_match_all("/([LR])(\d+)/", $data, $match, PREG_SET_ORDER);
        foreach ($match as [$action, $direction, $distance]) {

            // Determine new direction
            $d = ($d + ($direction === 'L' ? -90 : 90) + 360) % 360;

            // Single increments to determine the first crossing
            for ($i = 0; $i < $distance; $i++) {
                // Determine new location in grid
                $x += $d === 270 ? -1 : ($d === 90 ? 1 : 0);
                $y += $d === 0 ? -1 : ($d === 180 ? 1 : 0);

                // See if block is already visited
                if (!$first_crossing && isset($visited_blocks[$x][$y])) {
                    $first_crossing = [$x, $y];
                }

                // Store location of visited block
                $visited_blocks[$x][$y] = true;
            }
        }


        return
            [
                abs($x) + abs($y),
                abs($first_crossing[0]) + abs($first_crossing[1]),
            ];
    }
}

