<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2022;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2022
 */
class Day9 extends Assignment
{
    public function run(): array
    {
        // convert input to commands: [string $direction, int $steps]
        $commands = array_map(function ($line) {
            return explode(" ", trim($line));
        }, explode("\n", trim($this->getInput())));

        // return answers
        return
            [
                $this->countUniqueTailLocations($commands, 2),
                $this->countUniqueTailLocations($commands, 10)
            ];
    }

    public function countUniqueTailLocations(array $commands, int $rope_length): int
    {
        // initialize the location of the tail, and define the rope (arr[knot] = [y,x])
        $tail_locations["0/0"] = true;
        $rope = array_fill(0, $rope_length, [0, 0]);

        // process all commands
        foreach ($commands as [$direction, $steps]) {
            // loop the amount of steps
            for ($i = 0; $i < $steps; $i++) {
                // move the first element (head), up or down
                $rope[0][0] += match ($direction) {
                    "U" => -1,
                    "D" => 1,
                    default => 0
                };
                // or left/right
                $rope[0][1] += match ($direction) {
                    "L" => -1,
                    "R" => 1,
                    default => 0
                };

                // loop over the rest of the rope
                for ($knot = 1; $knot < $rope_length; $knot++) {
                    // determine the distance between the current knot and the parent knot
                    $dist_y = $rope[$knot - 1][0] - $rope[$knot][0];
                    $dist_x = $rope[$knot - 1][1] - $rope[$knot][1];
                    // if the distance between the parent is more than 1 (or -1) on the x- or y-axis
                    if (abs($dist_x) > 1 || abs($dist_y) > 1) {
                        // move the current knot one position closer to the parent knot
                        // the spaceship operator comparing to zero will convert negative values to -1,
                        // not change 0 and positive values to 1
                        $rope[$knot][0] += $dist_y <=> 0;
                        $rope[$knot][1] += $dist_x <=> 0;
                    }
                    // only the last value in the rope is the tail, we will register these unique locations
                    if ($knot === $rope_length - 1) {
                        // use the y and x coordinates as a unique array key
                        $tail_locations[$rope[$knot][0] . "/" . $rope[$knot][1]] = true;
                    }
                }
            }
        }

        // return the number of tail locations we have registered
        return count($tail_locations);
    }
}