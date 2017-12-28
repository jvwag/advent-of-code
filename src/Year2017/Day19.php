<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2017;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2017
 */
class Day19 extends Assignment
{
    private const UP = 0;
    private const RIGHT = 1;
    private const DOWN = 2;
    private const LEFT = 3;

    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $input = $this->getInput();
        $width = strpos($input, "\n");
        $grid = str_replace("\n", "", $input);

        // find the first x position based on the only character in the top row
        $x = strpos($grid, "|");

        // init state
        $direction = self::DOWN;
        $y = $iterations = 0;
        $found_letters = "";

        // loop until we are at the end
        while (true) {
            // count iterations for part 2 of the answer
            $iterations++;

            // update coordinates based on direction
            // @formatter:off
            switch ($direction) {
                case self::UP:    $y--; break;
                case self::RIGHT: $x++; break;
                case self::DOWN:  $y++; break;
                case self::LEFT:  $x--; break;
            }
            // @formatter:on

            // determine next step to take
            switch ($grid[($y * $width) + $x]) {

                // find new direction if we are on a crossing
                case "+":
                    // if we are going up or down, look to the left/right
                    if ($direction === self::DOWN || $direction === self::UP) {
                        // we look to the left and see if its empty, then we go to the right
                        if ($grid[($y * $width) + $x - 1] === " ") {
                            $direction = self::RIGHT;
                        // or to the left
                        } else {
                            $direction = self::LEFT;
                        }
                    } else {
                        // and if we go horizontal we look to the top bottom, if we don't see anything above, we go down
                        if ($grid[(($y - 1) * $width) + $x] === " ") {
                            $direction = self::DOWN;
                        // or, otherwise, up :)
                        } else {
                            $direction = self::UP;
                        }
                    }
                    break;

                // an empty space means we are at the end
                case " ":
                    break 2;

                // lines we ignore, these are fun for humans but useless for a great algorithm like me
                case "|":
                case "-":
                    break;

                // all other cases must be a found letter!
                default:
                    $found_letters .= $grid[($y * $width) + $x];
            }
        }

        // return answers
        return
            [
                $found_letters,
                $iterations
            ];
    }
}