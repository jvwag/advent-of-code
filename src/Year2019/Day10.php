<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2019;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2019
 */
class Day10 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $input = $this->parseInput($this->getInput());

        // use the counter as first answer, use the coordinates for the second answer
        [$output1, $x, $y] = $this->run1($input);
        $output2 = $this->run2($input, $x, $y);

        // return answers
        return
            [
                $output1,
                $output2,
            ];
    }

    public function run1($input): array
    {
        // get list of all possible vectors based on the grid size
        $vectors = $this->getVectors(count($input[0]), count($input));

        $highest = $output_x = $output_y = 0;
        // loop over the complete grid
        foreach ($input as $y => $rows) {
            foreach ($rows as $x => $item) {
                // if we find an asteroid, we will start spotting from here
                if ($item === "#") {
                    $c = 0;
                    // loop over all vectors
                    foreach ($vectors as $vector) {
                        // reset probing positions
                        [$test_x, $test_y] = [$x, $y];
                        // loop over increments of the vector until,
                        while (true) {
                            $test_x += $vector[0];
                            $test_y += $vector[1];
                            // if we are beyond our grid, than we also continue to a new vector
                            if (!isset($input[$test_y][$test_x])) {
                                break;
                            }
                            // or we find an asteroid, and add this to our counter, and continue to a new vector
                            if ($input[$test_y][$test_x] === "#") {
                                $c++;
                                break;
                            }
                        }
                    }
                    // if this number is higher than our previous calculation, store the x and y as output coordinates
                    if ($c > $highest) {
                        [$highest, $output_x, $output_y] = [$c, $x, $y];
                    }
                }
            }
        }

        // return our highest count, and the x and y coordinate of that location
        return [$highest, $output_x, $output_y];
    }

    public function run2($input, int $x, int $y)
    {
        // get list of all possible vectors based on the grid size
        $vectors = $this->getVectors(count($input[0]), count($input));

        $c = $test_x = $test_y = 0;
        // loop until we have found the 200th asteroid
        while (true) {
            // loop over all vectors
            foreach ($vectors as $vector) {
                // reset probing positions
                [$test_x, $test_y] = [$x, $y];
                // loop over increments of the vector until,
                while (true) {
                    $test_x += $vector[0];
                    $test_y += $vector[1];
                    // if we are beyond our grid, than we also continue to a new vector
                    if (!isset($input[$test_y][$test_x])) {
                        break;
                    }
                    // if we have found an asteroid, count it and: vaporize it
                    if ($input[$test_y][$test_x] === "#") {
                        $c++;
                        $input[$test_y][$test_x] = "@"; // <- see, vapor!
                        break;
                    }
                }
                // when we have found the 200th asteroid, we stop searching
                if ($c === 200) {
                    break 2;
                }
            }
        }

        // the last test location is our answer (and offset the x a bit)
        return ($test_x * 100) + $test_y;
    }

    /**
     * Get all possible non-overlapping vectors in a grid
     *
     * Now, this needs some explaining:
     *
     * With this function I will iterate over a complete grid and determine for every position
     * in the grid other than 0,0 the smallest, non-overlapping vector possible.
     *
     * By using the greatest common divisor of the x and y coordinate I will always use the shortest
     * version of the vector: 1,1 is a shorter than 2,2 and 4,5 is shorter than 20,25
     *
     * The arctangent calculation (used for part 2) used as a key for the vector list also acts as an
     * unique constraint to the vectors but does not get the shortest value. But it is used to sort the
     * list of vectors by the angle.
     *
     * @param int $x_size Width of the grid
     * @param int $y_size Height of the grid
     * @return int[][] Array of vectors
     */
    public function getVectors(int $x_size, int $y_size): array
    {
        $vectors = [];
        // loop over all coordinates in a grid
        for ($y = -$y_size; $y <= $y_size; $y++) {
            for ($x = -$x_size; $x <= $x_size; $x++) {
                // except 0,0
                if (!($x === 0 && $y === 0)) {
                    // calculate greatest common divisor of x and y coordinate
                    $gcd = self::gcd($x, $y);
                    // store shortest natural version of vector with the angle as key
                    $vectors[(string)atan2($x, $y)] = [($x / $gcd), ($y / $gcd)];
                }
            }
        }
        // sort vectors by angle
        krsort($vectors, SORT_NUMERIC);

        // return array with stripped keys
        return array_values($vectors);
    }

    /**
     * Calculate the greatest common divisor, with protection for zero input
     *
     * https://en.wikipedia.org/wiki/Euclidean_algorithm
     *
     * @param int $a Value a
     * @param int $b Value b
     * @return int Greatest common divisor of value a and b
     */
    public static function gcd(int $a, int $b): int
    {
        if ($a === 0 || $b === 0) {
            return max(abs($a), abs($b));
        }

        $r = $a % $b;
        return ($r !== 0) ? self::gcd($b, $r) : abs($b);
    }

    /**
     * Parse input
     *
     * @param string $str Raw input
     * @return string[][] Parsed input
     */
    public function parseInput($str): array
    {
        return array_map("str_split", explode("\n", trim($str)));
    }
}