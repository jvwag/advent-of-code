<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2023;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2023
 */
class Day2 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // init assignment given maximum values, and zero the outputs
        $max = ["red" => 12, "green" => 13, "blue" => 14];
        $output1 = $output2 = 0;

        // loop over all games
        foreach (explode("\n", $this->getInput()) as $line) {
            // extract game_id and list of cube subsets
            if (preg_match("/^Game (\d+): (.*)$/", $line, $match)) {
                $game_id = intval($match[1]);
                // init a counter array for each color
                $game = ["red" => 0, "green" => 0, "blue" => 0];
                // loop over all subsets in a game, and extract the count and color of each subset
                foreach (explode(";", $match[2]) as $subset) {
                    foreach (explode(",", $subset) as $cubes) {
                        [$count, $color] = explode(" ", trim($cubes));
                        // compare the color to crete a array of maximum values in all subsets from a game
                        if($game[$color] < $count) {
                            $game[$color] = $count;
                        }
                    }
                }

                // compare the maximum values from the subsets to the given maximum
                if($game["red"] <= $max["red"] && $game["green"] <= $max["green"] && $game["blue"] <= $max["blue"]) {
                    // increment the answer of the first part with the game_id if the subset maximums were within game limits
                    $output1 += $game_id;
                }
                // add the product of all subset maximum values as answer for the second part of the assignment
                $output2 += array_product($game);
            }
        }

        // return answers
        return
            [
                $output1,
                $output2
            ];
    }
}