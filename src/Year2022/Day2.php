<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2022;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2022
 */
class Day2 extends Assignment
{
    const ROCK = 1;
    const PAPER = 2;
    const SCISSORS = 3;

    const LOOSE = 1;
    const DRAW = 2;
    const WIN = 3;

    /**
     * @return array
     */
    public function run(): array
    {
        $points = [self::LOOSE => 0, self::DRAW => 3, self::WIN => 6];

        $outcomes = [
            self::LOOSE => [self::ROCK => self::SCISSORS, self::PAPER => self::ROCK, self::SCISSORS => self::PAPER],
            self::DRAW => [self::ROCK => self::ROCK, self::PAPER => self::PAPER, self::SCISSORS => self::SCISSORS],
            self::WIN => [self::ROCK => self::PAPER, self::PAPER => self::SCISSORS, self::SCISSORS => self::ROCK]
        ];

        // convert input
        $input = array_map(function ($a) {
            // this will change a sting like "A Z" to [1,3] and "B X" to [2,1]
            return [ord(substr($a, 0, 1)) - 64, ord(substr($a, 2, 1)) - 87];
        }, explode("\n", trim($this->getInput())));

        // for the first assignment, loop over all rounds and take the sum of all scores
        $part1 = array_sum(array_map(function ($round) use ($outcomes, $points) {
            // just naming the input to sane variable names
            [$opponents_choice, $my_choice] = $round;

            // the score is my choice (given, so 1, 2 or 3), and the number of points
            return $my_choice + match ($my_choice) {
                    // my choice is a wining outcome compared to my opponent
                    $outcomes[self::WIN][$opponents_choice] => $points[self::WIN],
                    // we have the same choice
                    $opponents_choice => $points[self::DRAW],
                    // or I loose
                    default => $points[self::LOOSE]
                };
        }, $input));

        // for the second assignment, again loop
        $part2 = array_sum(array_map(function ($round) use ($outcomes, $points) {
            // just naming the input to sane variable names
            [$opponents_choice, $required_outcome] = $round;

            // the score is the number of points based on my opponents choice and the required outcome (lookup table)
            // plus the number for points for that required outcome
            return $outcomes[$required_outcome][$opponents_choice] + $points[$required_outcome];
        }, $input));

        // return answers
        return
            [
                $part1,
                $part2
            ];
    }
}