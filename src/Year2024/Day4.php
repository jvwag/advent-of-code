<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2024;

use jvwag\AdventOfCode\Assignment;

class Day4 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $grid = [];
        $found_xmas = $found_xed_mas = 0;

        // put the input in a two-dimensional array, and store the size
        foreach (explode("\n", trim($this->getInput())) as $line) {
            $grid[] = str_split(trim($line));
        }
        $max_x = count($grid[0]);
        $max_y = count($grid);

        // loop over the complete grid
        for ($y = 0; $y < $max_y; $y++) {
            for ($x = 0; $x < $max_x; $x++) {
                // we will only look for 'X'-es as our starting position, and because we traverse the whole array
                // there will be no duplicates
                if ($grid[$y][$x] === "X") {
                    // loop over each direction we must look for "MAS"
                    foreach ([[-1, -1], [-1, 0], [-1, 1], [0, 1], [1, 1], [1, 0], [1, -1], [0, -1]] as [$y_offset, $x_offset]) {
                        // look for three more letters
                        for ($i = 1; $i < 4; $i++) {
                            // see if the following letter in the chosen direction matches the expected letter
                            // we protect going outside the grid by using the null coalescing operator for undefined grid positions
                            if (($grid[$y + ($y_offset * $i)][$x + ($x_offset * $i)] ?? null) !== "XMAS"[$i]) {
                                // not a match: try a new direction by skipping to the direction loop
                                continue 2;
                            }
                        }
                        // but if all letters are found, we have found the sting 'XMAS'
                        $found_xmas++;
                    }
                }

                // a 'MAS' cross will only be found where there is an 'A', and by concatenating the four letters
                // diagonally around the A we can check if it is valid (eg: only match MAS/SAM and not SAS/MAM)
                // if a grid position does not exist we use an empty sting, so it will not match the predefined valid strings
                if ($grid[$y][$x] === "A" &&
                    in_array(
                        ($grid[$y - 1][$x - 1] ?? "") .
                        ($grid[$y + 1][$x + 1] ?? "") .
                        ($grid[$y + 1][$x - 1] ?? "") .
                        ($grid[$y - 1][$x + 1] ?? ""), ["MSMS", "SMSM", "MSSM", "SMMS"])) {
                    // so we found an X'd 'MAS'
                    $found_xed_mas++;
                }
            }
        }

        // return answers
        return
            [
                $found_xmas,
                $found_xed_mas
            ];
    }
}