<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2018;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2018
 */
class Day4 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // init vars
        $total_downtime_per_guard = [];
        $total_downtime_per_guard_per_minute = [];
        $max_downtime_per_guard = [];
        $minute_max_downtime_per_guard = [];

        // get and convert input to lines
        $input = $this->getInput();
        $input = explode("\n", trim($input));

        // sort input
        sort($input);

        // parse every input line
        foreach ($input as $line) {
            // parse a row, fetching month, day, and minute
            if (preg_match("/^\[\d{4}\-(\d{2})-(\d{2}) \d{2}:(\d{2})\] (.*)$/", $line, $match)) {
                $month = (int)$match[1];
                $day = (int)$match[2];

                // switch for different cases
                if ($match[4] === "falls asleep") {
                    $start_minute = (int)$match[3];
                }
                if ($match[4] === "wakes up") {
                    $end_minute = (int)$match[3];
                }
                if (preg_match("/^Guard #(\d+) begins shift$/", $match[4], $match)) {
                    $guard_id = (int)$match[1];
                }
            }

            // if we have all data: guard shift ($guard_id), falls asleep ($start_minute) and wakeup ($end_minute)
            if (isset($start_minute, $end_minute, $guard_id, $month, $day)) {
                for ($x = $start_minute; $x < $end_minute; $x++) {
                    // increment counters as input for calculations later
                    $this->inc_key($total_downtime_per_guard, $guard_id);
                    $this->inc_key($total_downtime_per_guard_per_minute[$guard_id], $x);
                }

                // we could have another sleep/wakeup from the same guard, so only wait for a new start_minute/end_minute
                unset($start_minute, $end_minute);
            }
        }

        // determine guard_id which had the most downtime in total
        $part1_guard_id = $this->max_key($total_downtime_per_guard);
        // determine the minute that guard slept the most in all days
        $part1_minute = $this->max_key($total_downtime_per_guard_per_minute[$part1_guard_id]);

        // loop over all guard time minute data
        foreach ($total_downtime_per_guard_per_minute as $guard_id => $downtime_guard_per_minute) {
            // make a list of guards with maximum they slept for that minute in all days
            $max_downtime_per_guard[$guard_id] = max($downtime_guard_per_minute);
            // make a list of guards with the minute they were down the most
            $minute_max_downtime_per_guard[$guard_id] = $this->max_key($downtime_guard_per_minute);
        }

        // the selected guard is the guard with the most down minutes in all days
        $part2_guard_id = $this->max_key($max_downtime_per_guard);

        // return answers
        return
            [
                // guard_id that had the most downtime in total * the minute he slept the most in all days
                $part1_guard_id * $part1_minute,
                // guard_id that was down the most for a specific minute in all days * the found minute
                $part2_guard_id * $minute_max_downtime_per_guard[$part2_guard_id]
            ];
    }

    /**
     * First the first key of an array corresponding to the maximum value of the array
     *
     * @param array $array Array with values
     * @return false|int|string False if not found, array key if found
     */
    private function max_key(array $array)
    {
        return array_search(max($array), $array, true);
    }

    /**
     * Increment a element of an array, or set to 1 if the element does not exist/
     * The array is created if it does not exist.
     *
     * @param array|null $array Array
     * @param string|int $key
     */
    private function inc_key(&$array, $key): void
    {
        if (isset($array[$key])) {
            $array[$key]++;
        } else {
            $array[$key] = 1;
        }
    }
}