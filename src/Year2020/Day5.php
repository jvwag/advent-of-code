<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2020;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2020
 */
class Day5 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // get al the cards, and split them up in two groups, first 7 chars, and last 3 chars
        $lines = explode("\n", trim($this->getInput()));
        $cards = array_map(fn($s) => [substr($s, 0, 7), substr($s, -3)], $lines);

        // calculate all seat id's based on the row and column number encoded in binary space partitioning
        $seat_ids = array_map(fn($c) => ($this->BspToInt($c[0]) * 8) + $this->BspToInt($c[1]), $cards);

        // get some metadata from all our calculated seats
        $min_seat_id = min($seat_ids);
        $max_seat_id = max($seat_ids);
        $all_possible_seat_ids = range($min_seat_id, $max_seat_id);

        // return answers
        return
            [
                $max_seat_id, // the highest seat_id
                array_values(array_diff($all_possible_seat_ids, $seat_ids))[0] // and the only missing seat_id
            ];
    }

    /**
     * @param string $str Row or column encoded in binary space partitioning
     * @return int Row or column number
     */
    private function BspToInt(string $str): int
    {
        // this will work as well :)
        // return bindec(str_replace(["B", "R", "F", "L"], ["1", "1", "0", "0"], $str));

        $num = 0;
        $len = strlen($str);
        // loop over the number
        for ($x = 0; $x < $len; $x++) {
            // if we have a B or R, this means we need the higher number in our segment
            if ($str[$x] === "B" || $str[$x] === "R") {
                // so we add that segment to the number
                $num += (2 ** ($len - $x - 1));
            }
        }

        return $num;
    }
}