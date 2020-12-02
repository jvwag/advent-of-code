<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2017;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2017
 */
class Day3 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $input = (int) trim($this->getInput());
        $output2 = null;

        // init vars
        $c[0][0] = $s = 1;
        $x = $y = $l = $i = $dir = 0;

        // loop times given the input
        while (++$i < $input) {
            // change direction and step length
            if (--$s === 0) {
                $dir = ($dir + 1) % 4;
                if ($dir % 2 === 1) {
                    $l++;
                }
                $s = $l;
            }

            // update current coordinates
            switch ($dir) {
                case 0:
                    $y--;
                    break;
                case 1:
                    $x++;
                    break;
                case 2:
                    $y++;
                    break;
                case 3;
                    $x--;
                    break;
            }

            // determine coordinate value using sum of surrounding values
            $c[$x][$y] = 0;
            foreach ([[-1, -1], [-1, 0], [-1, 1], [0, -1], [0, 1], [1, -1], [1, 0], [1, 1]] as [$dx, $dy]) {
                $c[$x][$y] += $c[$x + $dx][$y + $dy] ?? 0;
            }

            // determine answer 2
            if ($output2 === null && $c[$x][$y] > $input) {
                $output2 = $c[$x][$y];
            }
        }

        // determine answer 1
        $output1 = abs($x) + abs($y);

        // return answers
        return
            [
                $output1,
                $output2,
            ];
    }
}