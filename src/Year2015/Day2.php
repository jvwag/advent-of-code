<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2015;

use jvwag\AdventOfCode\Assignment;

/**
 * Class Day2
 *
 * @package jvwag\AdventOfCode\Year2015
 */
class Day2 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input to matrix with dimensions
        $data = array_map(
            // split rows into columns
            function ($row) {
                // split rows with lxbxh data into array and convert to integer
                return array_map("\\intval", explode("x", trim($row)));
            },
            // split input into rows
            explode("\n", trim($this->getInput()))
        );

        // init output
        $paper = 0;
        $ribbon = 0;

        // loop over all package dimensions
        foreach ($data as $package) {
            [$l, $w, $h] = $package;

            // calculate proper size
            $paper += (2 * $l * $w) + (2 * $w * $h) + (2 * $h * $l);
            $ribbon += $l * $w * $h;

            // find two smallest values
            $a = [$l, $w, $h];
            sort($a);

            // add some more (see assignment)
            $paper += $a[0] * $a[1];
            $ribbon += (($a[0] * 2) + ($a[1] * 2));
        }

        // return answers
        return
            [
                $paper,
                $ribbon,
            ];
    }
}