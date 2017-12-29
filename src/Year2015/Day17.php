<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2015;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2015
 */
class Day17 extends Assignment
{
    private const LITERS = 150;

    /**
     * @return array
     */
    public function run(): array
    {
        return $this->calculate();
    }

    /**
     * @param int $liters
     *
     * @return array
     */
    public function calculate($liters = self::LITERS): array {
        // list of containers
        $containers = \array_map(
            function ($x) {
                return (int) \trim($x);
            },
            \explode("\n", \trim($this->getInput()))
        );

        // init vars
        $output1 = 0;
        $y_max = \count($containers);
        $x_max = 2 ** $y_max;
        $us = [];

        // loop over 2 to the power of the amount of containers (max combinations)
        for ($x = 0; $x < $x_max; $x++) {
            $u = 0;
            $sum = 0;
            // and loop over the amount of containers
            for ($y = 0; $y < $y_max; $y++) {
                // if we see the current combination as a bitmap, we only use the containers 1 and create a sum
                if (($x >> $y) & 1) {
                    $u++;
                    $sum += $containers[$y];
                }
            }

            // see if this combination happens to be 150, and count it (we also store the number of used containers)
            if ($sum === $liters) {
                $output1++;
                $us[] = $u;
            }
        }

        // for part two we will need to see in how many combinations we can store the
        // eggnog using the least amount of containers
        $output2 = 0;
        $min_containers = \min($us);
        foreach ($us as $u) {
            if ($u === $min_containers) {
                $output2++;
            }
        }

        // return answers
        return
            [
                $output1,
                $output2,
            ];
    }
}