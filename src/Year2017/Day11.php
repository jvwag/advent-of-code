<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2017;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2017
 */
class Day11 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $input = explode(",", trim($this->getInput()));

        // init vars
        $furthest = $distance = $x = $y = $z = 0;

        // loop over all input and adjust x/y/z based on given direction
        foreach ($input as $dir) {
            switch ($dir) {
                // @formatter:off
                case "se": $x++; $y--;       break;
                case "nw": $x--; $y++;       break;
                case "n":        $y++; $z--; break;
                case "s":        $y--; $z++; break;
                case "ne": $x++;       $z--; break;
                case "sw": $x--;       $z++; break;
                // @formatter:on
            }

            // calculate distance and store the furthest distance calculated
            $distance = (abs($x) + abs($y) + abs($z)) / 2;
            $furthest = max($furthest, $distance);
        }

        // return answers
        return
            [
                $distance,
                $furthest
            ];
    }
}