<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2018;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2018
 */
class Day5 extends Assignment
{
    private const ASCII_A = 65;
    private const ASCII_Z = 90;
    private const ASCII_LOWERCASE_OFFSET = 32;

    /**
     * @return array
     */
    public function run(): array
    {
        // get input
        $input = $this->getInput();

        // make units array (ascii values of letters)
        $units = str_split(trim($input));
        $units = array_map("ord", $units);

        // part one: the length of the collapsed input
        $output1 = $this->collapse($units);

        // part two: finding the smallest collapse while removing a unit
        $output2 = count($units);
        // loop over the all units
        for ($i = self::ASCII_A; $i <= self::ASCII_Z; $i++) {
            // remove a letter (ascii value, and lowercase (offset 32))
            $less_units = array_values(array_filter($units, function ($x) use ($i) {
                return $x !== $i && $x !== $i + self::ASCII_LOWERCASE_OFFSET;
            }));

            // calculate the lenght of collapsed version, and see if it is smaller than a previous letter calculation
            $output2 = min([$output2, $this->collapse($less_units)]);
        }

        // return answers
        return
            [
                $output1, // length of the collapsed input
                $output2  // length of the smallest collapsed input, where all occurrences of one unit is removed
            ];
    }


    /**
     * Collapse the array
     *
     * @param int[] $units ASCII integers [a-zA-Z]
     * @return int Count after collapsing
     */
    public function collapse(array $units): int
    {
        /** @noinspection CallableInLoopTerminationConditionInspection */
        // Loop over all units
        for ($i = 0; $i < count($units) - 1; $i++) {
            // If the current unit and the next unit are the same
            if (abs($units[$i] - $units[$i + 1]) === self::ASCII_LOWERCASE_OFFSET) {
                // Unset the current unit and next unit
                unset($units[$i], $units[$i + 1]);
                // Re-index the array (this is slow, maybe an Iterator could solve this)
                $units = array_values($units);
                // Set index two steps back, but never less than 0
                $i = max([$i - 2, 0]);
            }
        }

        // Return the count of units after collapsing
        return \count($units);
    }
}