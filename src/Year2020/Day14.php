<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2020;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2020
 */
class Day14 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $lines = explode("\n", $this->getInput());

        // return answers
        return
            [
                $this->run1($lines),
                $this->run2($lines),
            ];
    }

    public function run1(array $lines)
    {
        $or_mask = 0;
        $and_mask = 0;
        $memory = [];
        foreach ($lines as $line) {
            // if we match a mask, parse it
            if (preg_match("/^mask = (.*)$/", trim($line), $match)) {
                // the OR mask are all the 1's in the mask, and all X'es replaced by zero's
                $or_mask = bindec(str_replace("X", "0", $match[1]));
                // the AND mask are all the 0's in the mask, all X'es and 1's are replaced by 0's
                $and_mask = bindec(str_replace("X", "1", str_replace("1", "X", $match[1])));
            } // or if we have a memory line, parse it
            elseif (preg_match("/^mem\[(\d+)] = (\d+)$/", trim($line), $match)) {
                // get the address and value from the regex
                [$address, $value] = [$match[1], intval($match[2])];

                // create the address location if it does not exist
                if (!isset($memory[$address])) {
                    $memory[$address] = 0;
                }

                // apply the AND an OR mask to the value, and assign it to the address
                $memory[$address] = ($value & $and_mask) | $or_mask;

            }
        }

        // the solution is the sum of all memory contents
        return array_sum($memory);
    }

    public function run2(array $lines)
    {
        $or_mask = 0;
        $memory = [];
        $float_pos = [];
        foreach ($lines as $line) {
            // if we match a mask, parse it
            if (preg_match("/^mask = (.*)$/", trim($line), $match)) {
                // and store an OR mask
                $or_mask = bindec(str_replace("X", "0", $match[1]));
                // and get a list of positions there is a floating mask
                $float_pos = array_keys(array_filter(array_reverse(str_split(($match[1]))), fn($x) => $x === "X"));

            } // or if we have a memory line, parse it
            elseif (preg_match("/^mem\[(\d+)] = (\d+)$/", trim($line), $match)) {
                // get the address and value from the regex
                [$address, $value] = [$match[1], intval($match[2])];

                // apply the mask to the address
                $address = $address | $or_mask;

                /**
                 * @todo Refactor this code with logical arithmetics
                 *
                 * A bit ashamed I'm not solving this with logical arithmetics...
                 * This solution is based on replacing the values on the X marks in the mask
                 * using string replacement.
                 */

                // loop over all permutations of X values in the mask
                $c = count($float_pos);
                for ($x = 0; $x < 2 ** $c; $x++) {
                    // convert the number (of iterations of X) to a string with bits
                    $bin = sprintf("%0" . $c . "b", $x);

                    // copy the new address as a string with bits
                    $new_address = sprintf("%036b", $address);

                    // map the iterating number to the correct bits given the float_pos mapping
                    foreach ($float_pos as $k => $v) {
                        $new_address[35 - $v] = $bin[$k];
                    }
                    // and convert the string back to a number, this is our address
                    $new_address = bindec($new_address);

                    // create the address location if it does not exist
                    if (!isset($memory[$new_address])) {
                        $memory[$new_address] = 0;
                    }

                    // assign the value to the masked memory address
                    $memory[$new_address] = $value;
                }
            }
        }

        // the solution is the sum of all memory contents
        return array_sum($memory);
    }
}