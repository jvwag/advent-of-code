<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2015;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2015
 */
class Day12 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // decode input
        $input = json_decode(trim($this->getInput()), true);

        // return answers
        return
            [
                $this->countArray($input),
                $this->countArray($input, true),
            ];
    }

    /**
     * @param array $arr
     * @param bool $exclude_red
     *
     * @return int
     */
    public function countArray(array $arr, $exclude_red = false): int
    {
        $sum = 0;
        // loop over array
        foreach ($arr as $key => $value) {
            // recurse if element is array
            if (is_array($value)) {
                $sum += $this->countArray($value, $exclude_red);
            // add value if value is numeric
            } elseif (is_numeric($value)) {
                $sum += $value;
            }

            // optionally: exclude red
            if ($exclude_red && $value === "red" && !is_numeric($key)) {
                return 0;
            }
        }

        return $sum;
    }
}