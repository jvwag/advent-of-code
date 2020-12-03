<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2020;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year202
 */
class Day1 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input to a sorted list of integers
        $input = $this->getInput();
        $numbers = explode("\n", trim($input));
        $numbers = array_map("intval", $numbers);
        sort($numbers, SORT_NATURAL);

        // return answers
        return
            [
                $this->run1($numbers, 2020),
                $this->run2($numbers, 2020)
            ];
    }

    /**
     * Give the product of two found numbers in a sorted number list,
     * where the sum of the two numbers equals the target number.
     *
     * @param int[] $numbers Sorted list of integers
     * @param int $target Target number
     * @return int Product of found numbers
     */
    public function run1(array $numbers, int $target): ?int
    {
        $c = count($numbers);
        // loop over non overlapping combinations of two numbers
        for ($x = 0; $x < $c; $x++) {
            for ($y = 0; $y < $x; $y++) {
                // sum the two numbers
                $s1 = $numbers[$x] + $numbers[$y];

                // if the sum is higher than the target, we can early out
                if ($s1 > $target) {
                    break;
                }

                // if we find the target number we are done
                if ($s1 === $target) {
                    return $numbers[$x] * $numbers[$y];
                }
            }
        }

        return null;
    }

    /**
     * Give the product of three found numbers in a sorted number list,
     * where the sum of the three numbers equals the target number.
     *
     * @param int[] $numbers Sorted list of integers
     * @param int $target Target number
     * @return int Product of found numbers
     */
    public function run2(array $numbers, int $target): ?int
    {
        $c = count($numbers);
        for ($x = 0; $x < $c; $x++) {
            for ($y = 0; $y < $x; $y++) {
                // sum of two numbers
                $s1 = $numbers[$x] + $numbers[$y];

                // early out test on the first level
                if ($s1 > $target) {
                    break;
                }

                // now for the next level
                for ($z = 0; $z < $y; $z++) {
                    // sum of three numbers
                    $s = $numbers[$x] + $numbers[$y] + $numbers[$z];

                    // second level early out
                    if ($s > $target) {
                        break;
                    }

                    // if we find the target number we are done
                    if ($s === $target) {
                        return $numbers[$x] * $numbers[$y] * $numbers[$z];
                    }
                }
            }
        }

        return null;
    }
}