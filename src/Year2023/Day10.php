<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2023;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2023
 */
class Day10 extends Assignment
{
    // Possible connecting positions for each character on the map
    const POSSIBILITIES = [
        "." => [],
        "|" => [[0, 1], [0, -1]],
        "-" => [[1, 0], [-1, 0]],
        "L" => [[0, -1], [1, 0]],
        "F" => [[0, 1], [1, 0]],
        "J" => [[0, -1], [-1, 0]],
        "7" => [[0, 1], [-1, 0]],
        "S" => [[0, -1], [0, 1], [-1, 0], [1, 0]],
    ];

    /**
     * @return array
     */
    public function run(): array
    {
        // init vars
        $prev_x = $prev_y = $x = $y = -1;
        $map = $loop = [];

        // loop over input
        foreach (explode("\n", trim($this->getInput())) as $input_y => $line) {
            foreach (str_split($line) as $input_x => $char) {
                // fill map array with characters
                $map[$input_x][$input_y] = $char;
                // save location of starting point
                if ($char === "S") {
                    [$x, $y] = [$input_x, $input_y];
                }
            }
        }

        // start loop
        do {
            // fetch the possible connecting directions given the current map position
            foreach (self::POSSIBILITIES[$map[$x][$y]] as [$x1_offset, $y1_offset]) {
                // if a connecting position exists, and it is not the previous position we have come from
                if (isset($map[$x + $x1_offset][$y + $y1_offset]) && ($x + $x1_offset !== $prev_x || $y + $y1_offset !== $prev_y)) {
                    // loop over the possible connections of the connecting map tile
                    foreach (self::POSSIBILITIES[$map[$x + $x1_offset][$y + $y1_offset]] as [$x2_offset, $y2_offset]) {
                        // now test if the two tiles have a match and can connect to each-other
                        if ($x1_offset + $x2_offset === 0 && $y1_offset + $y2_offset === 0) {
                            // store a copy of the current position in loop, and take not of the previous x and y pos
                            $loop[] = [$prev_x, $prev_y] = [$x, $y];
                            // increment x and y with the found direction
                            $x += $x1_offset;
                            $y += $y1_offset;
                            // and continue to the new tile
                            break 2;
                        }
                    }
                }
            }
        } while ($map[$x][$y] !== "S"); // loop until we are back at the start

        // init map size and answer
        $max_x = count($map[0]);
        $max_y = count($map);
        $enclosed_tiles_in_the_loop = 0;
        // define variables: if we are inside, and a flag to mark we are waiting to an up point
        $inside = $waiting_for_j = false;
        // we loop over all items in the map
        for ($y = 0; $y < $max_y; $y++) {
            for ($x = 0; $x < $max_x; $x++) {
                // we determine a transition from inside or outsize of the loop by looking at transitions at
                // loop points
                if (in_array([$x, $y], $loop)) {
                    // if we loop over the map from left to right, and top to bottom, there are only three places
                    // where the intersection of the loop will switch from inside to outside:
                    // 1. at a '|' char
                    // 2. at a 'J' char, if we have found a 'F' char previously
                    // 3. at a '7' char, if we have found a 'L' char previously
                    // all other cases, for example F--7 or L--J are not really transitions from inside to outside
                    if ($map[$x][$y] === "|" || // the simplest case: transition over a straight line
                        ($map[$x][$y] === "J" && $waiting_for_j === true) || // from F to J
                        ($map[$x][$y] === "7" && $waiting_for_j === false)) { // from L to 7
                        $inside = !$inside; // toggle the inside flag
                    } elseif ($map[$x][$y] === "L") {
                        $waiting_for_j = false; // mark we have found a 'L', now waiting for '7' not 'J'
                    } elseif ($map[$x][$y] === "F") {
                        $waiting_for_j = true; // mark we have found a 'F', now waiting for 'J' not '7'
                    }
                } elseif ($inside) {
                    // if we are not examining a route point, and we are inside: add all positions to our total
                    $enclosed_tiles_in_the_loop++;
                }
            }
        }

        // return answers
        return
            [
                count($loop) / 2, // count of loop entries divided by two is the farthest point from the starting pos
                $enclosed_tiles_in_the_loop
            ];
    }
}