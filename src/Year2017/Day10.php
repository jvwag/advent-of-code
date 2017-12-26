<?php

namespace jvwag\AdventOfCode\Year2017;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2017
 */
class Day10 extends Assignment
{
    // Default hash internal length
    const DEFAULT_LENGTH = 256;

    // Suffix of integers given in part 2
    const PART2_INTEGERS = [17, 31, 73, 47, 23];

    // Number of rounds to hash for part 2
    const PART2_ROUNDS = 64;

    /**
     * @return array
     */
    public function run(): array
    {
        // get the input
        $input = trim($this->getInput());

        // return answers
        return
            [
                $this->run1($input),
                $this->run2($input),
            ];
    }

    /**
     * Part 1
     *
     * @param string $input Input data in comma separated form
     * @param int $length Length of hash array
     * @return int Product of first two elements of the hash array
     */
    public function run1($input, $length = self::DEFAULT_LENGTH)
    {
        // convert ascii list of commas separated numbers to array of integers
        $inputs = array_map("\intval", explode(",", $input));

        // calculate
        $arr = $this->knotHash($inputs, 1, $length);

        // return product of first two elements
        return (int) ($arr[0] * $arr[1]);
    }

    /**
     * Part 2
     *
     * @param string $input ASCII string
     * @return string knothHash in dense format
     */
    public function run2($input)
    {
        // convert binary data to array of integers
        $inputs = array_map("\ord", str_split($input));

        // add the mandatory second suffix for the input
        $inputs = array_merge($inputs, self::PART2_INTEGERS);

        // calculate 64 passes
        $sparse_hash = $this->knotHash($inputs, self::PART2_ROUNDS);

        // convert the array to a dense hash and return
        return $this->denseHash($sparse_hash);
    }

    /**
     * Calculate knotHash
     *
     * @param int[] $inputs Array of integers
     * @param int $rounds Number of rounds
     * @param int $length Length of array
     * @return int[] Array of the hash
     */
    public function knotHash($inputs, $rounds = 1, $length = self::DEFAULT_LENGTH)
    {
        // init array integers of given size
        $arr = range(0, $length - 1);

        $pos = 0;
        $skip = 0;
        // loop over the number of rounds to hash
        for ($x = 0; $x < $rounds; $x++) {
            // loop over the input
            foreach ($inputs as $input) {
                // this is the half of the input length, used to reverse
                $c = floor($input / 2);
                for ($r = 0; $r < $c; $r++) {
                    // calculate first and last position to flip values
                    $first_pos = ($pos + $r) % $length;
                    $last_pos = ($pos + $input - $r - 1) % $length;

                    // flip two values
                    $tmp = $arr[$first_pos];
                    $arr[$first_pos] = $arr[$last_pos];
                    $arr[$last_pos] = $tmp;
                }
                // determine new position to start
                $pos = ($pos + $input + $skip++) % $length;
            }
        }

        // return the hash array
        return $arr;
    }

    /**
     * Calculate dense hash from array of integers
     *
     * @param int[] $sparse_hash Array of 256 integers
     * @return string Hash
     */
    private function denseHash($sparse_hash)
    {
        // start with an array of 16 elements
        $xor = array_fill(0, 16, 0);

        // loop over all elements in sparse hash
        for ($x = 0; $x < 256; $x++) {
            // xor the value to the specific group (0-15)
            $xor[(int)\floor($x / 16)] ^= $sparse_hash[$x];
        }

        // join the xor arrag and format it to hex
        return join("", array_map(function ($x) {
            return sprintf("%02x", $x);
        }, $xor));
    }
}