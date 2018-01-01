<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2017;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2017
 */
class Day15 extends Assignment
{
    private const GEN1_MUL = 16807;
    private const GEN2_MUL = 48271;
    private const DIVISOR = 2147483647;
    private const PASSES_PART1 = 40000000;
    private const PASSES_PART2 = 5000000;
    private const GEN1_MOD = 4;
    private const GEN2_MOD = 8;

    /**
     * @return array
     */
    public function run(): array
    {
        // get the input values
        preg_match("/(\d+)\D*(\d+)/m", trim($this->getInput()), $match);
        /** @todo remove noinspection and $tmp after fix for https://youtrack.jetbrains.com/issue/WI-34517 */
        /** @noinspection PhpUnusedLocalVariableInspection */
        [$tmp, $start1, $start2] = $match;

        // init the answers
        $match_count1 = 0;
        $match_count2 = 0;

        // loop for part1
        $gen1 = $start1;
        $gen2 = $start2;
        for ($x = 0; $x < self::PASSES_PART1; $x++) {
            // calculate new values for generator1 and generator2
            $gen1 = (int)(($gen1 * self::GEN1_MUL) % self::DIVISOR);
            $gen2 = (int)(($gen2 * self::GEN2_MUL) % self::DIVISOR);

            // compare the values and add the counter on a match
            if (($gen1 & 0xffff) === ($gen2 & 0xffff)) {
                $match_count1++;
            }
        }

        // loop for part 2;
        $x = 0;
        $gen1 = $start1;
        $gen2 = $start2;
        $comp_gen1 = $comp_gen2 = null;
        while (true) {
            // if there is no valid generator1 value, try to create a new one
            if (!$comp_gen1) {
                // calculate new value
                $gen1 = (int)(($gen1 * self::GEN1_MUL) % self::DIVISOR);
                // if it is valid, assign to comparator variable
                if ($gen1 % self::GEN1_MOD === 0) {
                    $comp_gen1 = $gen1;
                }
            }
            // if there is no valid generator2 value, try to create a new one
            if (!$comp_gen2) {
                // calculate new value
                $gen2 = (int)(($gen2 * self::GEN2_MUL) % self::DIVISOR);
                // if it is valid, assign to comparator variable
                if ($gen2 % self::GEN2_MOD === 0) {
                    $comp_gen2 = $gen2;
                }
            }
            // if there are two values to compare, do so
            if ($comp_gen1 && $comp_gen2) {
                // do they match?
                if (($comp_gen1 & 0xffff) === ($comp_gen2 & 0xffff)) {
                    // count the match
                    $match_count2++;
                }
                // clear the two comparator variables
                $comp_gen1 = null;
                $comp_gen2 = null;

                // and see if were done with comparing
                if($x++ > self::PASSES_PART2) {
                    break;
                }
            }
        }

        // return answers
        return
            [
                $match_count1,
                $match_count2
            ];
    }
}