<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2021;
ini_set("memory_limit", "4G");

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2021
 */
class Day6 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input to list with counter of fish ages
        $fish = array_count_values(array_map("intval", explode(",", trim($this->getInput()))));

        // init
        $number_of_fish_at_cycle_80 = 0;

        // loop 256 times, for assignment part two
        for ($x = 0; $x < 256; $x++) {
            // init a new empty fish array
            $new_fish = array_fill(0, 9, 0);

            // loop over all current fish
            foreach ($fish as $day => $count) {
                // if it is spawning day,
                if ($day === 0) {
                    // new fish start at 8 days
                    $new_fish[8] += $count;
                    // old fish start at 6 days
                    $new_fish[6] += $count;
                } else {
                    // all other fish creep one day closer to spawning day
                    $new_fish[$day - 1] += $count;
                }
            }
            // overwrite the fish array with the new fish array
            $fish = $new_fish;

            // the 80'th cycle is the answer for part one
            if($x === 79) {
                $number_of_fish_at_cycle_80 = array_sum($fish);
            }
        }

        // and the number of fish at the last cycle
        $number_of_fish_at_cycle_256 = array_sum($fish);

        // return answers
        return
            [
                $number_of_fish_at_cycle_80,
                $number_of_fish_at_cycle_256
            ];
    }
}