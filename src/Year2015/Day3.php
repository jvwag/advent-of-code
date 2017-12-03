<?php

namespace jvwag\AdventOfCode\Year2015;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2015
 */
class Day3 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $input = \str_split($this->getInput());

        // init output
        $a = $b = [];

        // init locations (index: x/y)
        $a["0/0"] = true;
        $b["0/0"] = true;

        // init locations (index 0: santa only, 1: santa alternating with robosanta, 2: robosanta)
        $x = [0, 0, 0];
        $y = [0, 0, 0];

        // loop over all characters
        foreach ($input as $z => $char) {
            // determine who moves: santa(1) or robosanta(2)
            $p = ($z % 2) + 1;

            // update position x and y
            switch ($char) {
                case ">":
                    $x[0]++;
                    $x[$p]++;
                    break;
                case "<":
                    $x[0]--;
                    $x[$p]--;
                    break;
                case "^":
                    $y[0]++;
                    $y[$p]++;
                    break;
                case "v":
                    $y[0]--;
                    $y[$p]--;
                    break;
            }

            // keep track of location for santa only locations
            $a[$x[0] . "/" . $y[0]] = true;

            // keep track of santa/robosanta locations
            $b[$x[$p] . "/" . $y[$p]] = true;
        }

        // return answers
        return
            [
                \count($a),
                \count($b),
            ];
    }
}