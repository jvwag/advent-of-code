<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2018;

use jvwag\AdventOfCode\Assignment;
use SplDoublyLinkedList;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2018
 */
class Day9 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        preg_match("/^(\d+) players; last marble is worth (\d+) points$/", trim($this->getInput()), $match);
        $player_count = (int)$match[1];
        $last_marble = (int)$match[2];

        // init empty score tables
        $part1_wins = $part2_wins = array_fill(0, $player_count, 0);

        // create linked list with one value
        $arr = new SplDoublyLinkedList();
        $arr->push(0);

        // loop over the number of marble's given, and some more (x100) for part 2
        for ($x = 1; $x < $last_marble * 100; $x++) {
            // every twenty-third marble we do something special
            if ($x % 23 === 0) {
                // move back 6 steps in the list
                for ($y = 0; $y < 7; $y++) {
                    $arr->unshift($arr->pop());
                }
                // and use the 7th item + the count of marbles as the score for this player
                $part2_wins[$x % $player_count] += $x + $arr->pop();

                // and step one forward
                $arr->push($arr->shift());
            } else {
                // all other cases, we just step forward and add a marble
                $arr->push($arr->shift());
                $arr->push($x);
            }

            // when we hit the given marble limit, we have finished part 1
            if ($x === $last_marble) {
                // so we copy the score table
                $part1_wins = $part2_wins;
            }
        }

        // return answers
        return
            [
                max($part1_wins), // highest score for part one
                max($part2_wins)  // highest score for part two
            ];
    }
}