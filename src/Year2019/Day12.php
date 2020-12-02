<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2019;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2019
 */
class Day12 extends Assignment
{
    private const MAX_AXES = 2;

    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $input = $this->parseInput($this->getInput());

        // return answers
        return
            [
                $this->run1($input, 1000), // answer calculated after 1000 steps
                $this->run2($input),
            ];
    }

    /**
     * @param int[][] $positions Position Array
     * @param int $steps Number of steps to run
     * @return int For each position after given number of steps, the sum of: sum of x,y,z position multiplied by sum of x,y,z velocity
     */
    public function run1(array $positions, int $steps): int
    {
        $i = 0;
        $velocities = [];
        // loop for a number of steps
        while ($i++ !== $steps) {
            // calculate velocities
            $velocities = $this->calculateVelocities($positions, $velocities);
            // apply velocities to position
            $positions = $this->moveMoons($positions, $velocities);
        }

        $output = 0;
        // loop over all current positions and sum
        foreach ($positions as $k => $position) {
            $output +=
                array_sum(array_map("abs", $position)) * // sum of x,y,z position, multiplied by
                array_sum(array_map("abs", $velocities[$k])); // sum of x,y,z velocities
        }

        return $output;
    }

    public function run2(array $positions): int
    {
        // store start position
        $start_positions = $positions;

        $i = 0;
        $cycles = $velocities = [];
        $cycle_search = range(0, self::MAX_AXES);
        // loop, break if answer is found
        while ($cycle_search) {
            // move moons
            $positions = $this->moveMoons($positions, $velocities);

            // loop over the number of cycles to find
            foreach ($cycle_search as $xyz_key => $xyz) {
                // loop over all positions
                foreach ($positions as $id => $position) {
                    // if a position is equal to any other position, continue with stepping
                    if (($position[$xyz] ?? null) !== ($start_positions[$id][$xyz] ?? null) || ($velocities[$id][$xyz] ?? null) !== 0) {
                        continue 2;
                    }
                }
                // if all positions are the same, store this position of this axis
                $cycles[$xyz] = $i;

                // and unset this axis in the search list
                unset($cycle_search[$xyz_key]);
            }

            // calculate velocities
            $velocities = $this->calculateVelocities($positions, $velocities);
            $i++;
        }

        // now find the least common multiple of the found cycles
        return self::array_lcm($cycles);
    }

    /**
     * Find least common multiple in array of numbers
     *
     * @param int[] $numbers List of numbers
     * @return int Least common multiple
     */
    public static function array_lcm(array $numbers): int
    {
        $output = array_pop($numbers);
        while ($numbers) {
            $output = self::lcm($output, array_pop($numbers));
        }
        return $output;
    }

    /**
     *  Find the least common multiple of two values
     *
     * @param int $num1 First number
     * @param int $num2 Second number
     * @return int Least common multiple
     */
    public static function lcm(int $num1, int $num2): int
    {
        return ($num1 * $num2 / Day10::gcd($num1, $num2));
    }

    public function parseInput(string $input): array
    {
        $output = [];
        foreach (explode("\n", trim($input)) as $line) {
            if (preg_match("/^<x=(-?\d+), y=(-?\d+), z=(-?\d+)>$/", $line, $match)) {
                array_shift($match);
                $output[] = array_map("intval", $match);
            }
        }

        return $output;
    }

    /**
     * Move all moons given their velocities
     *
     * @param int[][] $positions Positions, array of [x,y,z]
     * @param int[][] $velocities Velocities, array of [x,y,z]
     * @return int[][] Positions, array of [x,y,z]
     */
    private function moveMoons(array $positions, array $velocities): array
    {
        // loop over all positions
        foreach ($positions as $id => $position) {
            // loop over axes (x, y, z)
            foreach (range(0, self::MAX_AXES) as $xyz) {
                // add velocity of this axis to the axis of the position
                if(isset($velocities[$id][$xyz])) {
                    $positions[$id][$xyz] += $velocities[$id][$xyz];
                }
            }
        }

        // return positions
        return $positions;
    }

    /**
     * Calculate velocities given the current velocities and the distance to the other moons
     *
     * @param int[][] $positions Positions, array of [x,y,z]
     * @param int[][] $velocities Velocities, array of [x,y,z]
     * @return int[][] Velocities, array of [x,y,z]
     */
    private function calculateVelocities(array $positions, array $velocities): array
    {
        // loop over all positions
        foreach ($positions as $this_id => $this_pos) {
            // and over all other positions
            foreach ($positions as $other_pos) {
                // and loop over all axis
                foreach (range(0, self::MAX_AXES) as $xyz) {
                    // init the velocity value if not set
                    $velocities[$this_id][$xyz] = $velocities[$this_id][$xyz] ?? 0;
                    // if our distance to the other moon is lower
                    if ($this_pos[$xyz] < $other_pos[$xyz]) {
                        $velocities[$this_id][$xyz]++; // increment our velocity
                    } elseif ($this_pos[$xyz] > $other_pos[$xyz]) {
                        $velocities[$this_id][$xyz]--; // else, reduce our velocity
                    }
                }
            }
        }

        // return velocities
        return $velocities;
    }
}