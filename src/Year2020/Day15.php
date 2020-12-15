<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2020;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2020
 */
class Day15 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $input = array_map("intval", explode(",", trim($this->getInput())));

        // return answers
        return
            [
                $this->memory($input, 2020),
                $this->memory($input, 30000000)
            ];
    }

    /**
     * Memory game
     *
     * @param int[] $starting_numbers List of starting numbers for the game
     * @param int $max Number of passes
     * @return int The number that was last said
     */
    public function memory(array $starting_numbers, int $max): int
    {
        $say = null;
        $prev = null;
        for ($turn = 0; $turn < $max; $turn++) {
            // if we have starting numbers left, inject them
            if ($starting_numbers) {
                $say = array_shift($starting_numbers);
            }
            // or, we need to come up with a thing to say
            else {
                // if the previous number was not set before
                if (!isset($history[$prev])) {
                    // we say zero
                    $say = 0;
                } else {
                    // or else, we take say how many turns before we last said the number
                    $say = $turn - $history[$prev];
                }
            }

            // if we have a previous number, we should remember it
            if ($prev !== null) {
                $history[$prev] = $turn;
            }

            // and the thing we said, will go as the previous number next round
            $prev = $say;
        }

        // return the number we have said last
        return $say;
    }

}