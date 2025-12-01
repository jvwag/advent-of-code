<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2025;

use jvwag\AdventOfCode\Assignment;

class Day1 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $input = $this->getInput();
        $arr = explode("\n", trim($input));

        // initial value for answers
        $count_at_zero = $count_passing_zero = 0;
        $position = 50;
        foreach ($arr as $line) {
            // parsing input: determine direction and distance from input line
            $direction = str_starts_with($line, "R") ? 1 : -1;
            $distance = intval(substr($line, 1));

            // part2: calculate the number of times the position will pass zero
            // based on our current position, the distance and direction
            $count_passing_zero += intdiv(abs($position + $distance * $direction), 100);

            // part2: edge case, if we go right, and the position is not zero, and the distance is more or equal
            // to the current position, we will count an extra loop because we started counting from a
            if($direction === -1 && $position !== 0 && $distance >= $position) {
                $count_passing_zero++;
            }

            // calculate the new position: add the new distance (with direction modifier)
            $position += $direction * $distance;
            // keep outcome between 0-99
            $position %= 100;
            // if negative, add 100
            $position += $position < 0 ? 100 : 0;

            // part1: count all steps where the position is equal to zero
            if($position === 0) {
                $count_at_zero++;
            }
        }

        // return answers
        return
            [
                $count_at_zero,
                $count_passing_zero
            ];
    }
}