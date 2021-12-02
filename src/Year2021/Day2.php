<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2021;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2021
 */
class Day2 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // init values
        $horizontal = $aim = $depth = 0;

        // loop over input
        foreach (explode("\n", $this->getInput()) as $line) {
            // match command line
            if (preg_match("/^(.*) (\d+)$/", $line, $match)) {
                // take the values from the match array
                [, $command, $value] = $match;
                // process each command
                switch ($command) {
                    case "forward":
                        // forward does also send you up or down
                        $horizontal += $value;
                        $depth += $aim * $value;
                        break;
                    case "up":
                        // up changes the aim: down?
                        $aim -= $value;
                        break;
                    case "down":
                        // and down must be up, alice?
                        $aim += $value;
                        break;
                }
            }
        }

        // return answers
        return
            [
                $horizontal * $aim,
                $horizontal * $depth
            ];
    }
}