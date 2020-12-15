<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2020;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2020
 */
class Day13 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // parse input
        $input = explode("\n", $this->getInput());

        // get departure time
        $departure_time = intval(trim(array_shift($input)));

        // get bus numbers, and strip X'es
        $bus_numbers = array_filter(array_map("intval", explode(",", trim(array_shift($input)))), fn($x) => $x !== 0);

        // return answers
        return
            [
                $this->run1($departure_time, $bus_numbers),
                $this->run2($bus_numbers)
            ];
    }

    /**
     * @param int $departure_time
     * @param array $bus_numbers
     * @return int
     */
    public function run1(int $departure_time, array $bus_numbers): int
    {
        // loop over all bus numbers to find the next bus from the departure time
        $next_bus = [];
        foreach ($bus_numbers as $bus) {
            $next_bus[$bus] = intval(($departure_time - (ceil($departure_time / $bus) * $bus)) * -1);
        }

        // get the time of first departing bus
        $minutes = min($next_bus);

        // get the bus number
        $bus = array_search(min($next_bus), $next_bus);

        // return the minutes times the bus number
        return intval($minutes * $bus);
    }

    /**
     * Optimized version of
     *
     * @param array $bus_numbers
     * @return int
     */
    public function run2(array $bus_numbers): int
    {
        $t = 0;
        $step = 1;
        // loop over all bus numbers
        foreach ($bus_numbers as $offset => $bus) {
            // increment the time with a step until we find a bus that matches this cyle
            while (($t + $offset) % $bus !== 0) {
                // Add the step until we find a number that fits the current bus time
                $t += $step;
            }
            // if we found this time, this is the new step value
            $step *= $bus;
        }

        // return the time
        return $t;
    }

    /**
     * This slow version does work with the solution and was the best I could come
     * up with without checking other people for inspiration.
     *
     * It will run the unittest in a timely way.
     *
     * @param array $bus_numbers
     * @return int
     */
    public function run2_slow(array $bus_numbers): int
    {
        $first_bus_number = reset($bus_numbers);
        $d = 0;

        while (true) {
            $d += $first_bus_number;
            $first_bus_departure = null;
            foreach ($bus_numbers as $offset => $bus) {
                if ($bus !== 0) {
                    $next_bus_departure = (ceil($d / $bus) * $bus);
                    if ($first_bus_departure === null) {
                        $first_bus_departure = $next_bus_departure;
                        continue;
                    }
                    if ($next_bus_departure !== $first_bus_departure + $offset) {
                        continue 2;
                    }
                }
            }
            break;
        }

        return $d;
    }
}