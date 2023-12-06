<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2023;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2023
 */
class Day6 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // parse rows into time and distance arrays
        $rows = explode("\n", trim($this->getInput()));
        $time = array_map("intval", array_slice(preg_split("/\s+/", $rows[0]), 1));
        $distance = array_map("intval", array_slice(preg_split("/\s+/", $rows[1]), 1));

        // start with 1 (base for product)
        $product_of_ways_to_beat_the_races = 1;
        // loop over all time/distance combinations
        for ($i = 0; $i < count($time); $i++) {
            // calculate the number of ways to beat a race, and multiply it with the previous time/distance combination
            $product_of_ways_to_beat_the_races *= $this->calculateNumberOfWaysToBeatARace($time[$i], $distance[$i]);
        }

        // combine all time and distance characters from the assignment and calculate once more for one race
        $number_of_beaten_races_with_long_number = $this->calculateNumberOfWaysToBeatARace(
            intval(join("", $time)),
            intval(join("", $distance))
        );

        // return answers
        return
            [
                $product_of_ways_to_beat_the_races,
                $number_of_beaten_races_with_long_number
            ];
    }

    /**
     * This could probably be optimized by calculating the min and max value and returning the difference
     * But since I didn't finish day5-part2 I will leave it at this and
     */
    public function calculateNumberOfWaysToBeatARace(int $time, int $distance): int
    {
        $x = 0;
        // loop over all possible time combinations
        for ($i = 0; $i < $time; $i++) {
            // calculate the distance with all different hold times and increment for each time it was further
            if (($time - $i) * $i > $distance) {
                $x++;
            }
        }

        return $x;
    }
}