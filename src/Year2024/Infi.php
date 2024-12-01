<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2024;

use jvwag\AdventOfCode\Assignment;

class Infi extends Assignment
{
    public const INPUT_LOCATION = "infi-2024.txt";
    public const GRID_MAX = 30;
    private const LOOKUP_TABLE_3D = [[-1, 0, 0], [1, 0, 0], [0, -1, 0], [0, 1, 0], [0, 0, -1], [0, 0, 1]];
    private array $grid;
    private array $instructions;

    /**
     * @return array
     */
    public function run(): array
    {
        // xdebug has a default nesting level of 512, without xdebug it is limited to memory
        // in this application the maximum depth could be GRID_MAX cubed (when a cloud covers
        // all spaces in the grid)
        ini_set("xdebug.max_nesting_level", pow(self::GRID_MAX, 3));

        // parse the input
        foreach (explode("\n", $this->getInput()) as $line) {
            $boom = explode(" ", trim($line));
            // when an instruction does not have an argument, use null
            $this->instructions[] = [$boom[0], $boom[1] ?? null];
        }

        // loop over the complete grid
        $sum = 0;
        for ($x = 0; $x < self::GRID_MAX; $x++) {
            for ($y = 0; $y < self::GRID_MAX; $y++) {
                for ($z = 0; $z < self::GRID_MAX; $z++) {
                    // to run the program for each point in the grid
                    $value = $this->runInstructions($x, $y, $z);
                    // if there is a cloud
                    if ($value > 0) {
                        // add it to the grid list
                        $this->grid[$x][$y][$z] = true;
                    }
                    // and sum all the cloud intensity values
                    $sum += $value;
                }
            }
        }

        // now we will find the first point where there is a cloud
        $clouds = 0;
        for ($x = 0; $x < self::GRID_MAX; $x++) {
            for ($y = 0; $y < self::GRID_MAX; $y++) {
                for ($z = 0; $z < self::GRID_MAX; $z++) {
                    if (isset($this->grid[$x][$y][$z])) {
                        // use this recursive function to clean up all connected grid points with a cloud value
                        $this->removeGridPositionAndNeighbours($x, $y, $z);
                        // and count each time we do this
                        $clouds++;
                    }
                }
            }
        }

        // return answers
        return
            [
                $sum,
                $clouds
            ];
    }

    public function runInstructions(int $x, int $y, int $z): mixed
    {
        // init stack and program counter
        $stack = [];
        $program_counter = 0;

        // lookup table for the uppercase X, Y and Z references
        $position = ["X" => $x, "Y" => $y, "Z" => $z];

        // loop over the program
        do {
            // read the instruction and argument
            [$instruction, $argument] = $this->instructions[$program_counter];
            switch ($instruction) {
                // add a value to the stack
                case "push":
                    if (in_array($argument, ["X", "Y", "Z"])) { // lookup if the argument is a reference to the position
                        $stack[] = $position[$argument];
                    } else { // or just the integer that needs to be added to the stack
                        $stack[] = intval($argument);
                    }
                    break;

                // sum the last two values on the stack, and put the result back on the stack
                case "add":
                    $stack[] = array_pop($stack) + array_pop($stack);
                    break;

                // get a value from the stack, and add the value to the program counter if it is greater than zero
                case "jmpos":
                    $value = array_pop($stack);
                    if ($value >= 0) {
                        $program_counter += intval($argument);
                    }
                    break;
            }

            // increment the program counter after each instruction
            $program_counter++;

            // only stop executing when a 'ret' instruction is reached
        } while ($instruction !== "ret");

        // return the last value on the stack as result
        return array_pop($stack);
    }

    private function removeGridPositionAndNeighbours(int $x, int $y, int $z): void
    {
        // remove the given point in the grid
        unset($this->grid[$x][$y][$z]);
        // look at all grid position adjacent to the current position
        foreach (self::LOOKUP_TABLE_3D as [$x_offset, $y_offset, $z_offset]) {
            // if it is a cloud
            if (isset($this->grid[$x + $x_offset][$y + $y_offset][$z + $z_offset])) {
                // recursively call this function to remove all connected grit elements that is a cloud
                $this->removeGridPositionAndNeighbours($x + $x_offset, $y + $y_offset, $z + $z_offset);
            }
        }
    }

    public function setInstructions(array $instructions): void
    {
        $this->instructions = $instructions;
    }
}