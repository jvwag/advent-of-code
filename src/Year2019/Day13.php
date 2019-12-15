<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2019;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2019
 */
class Day13 extends Assignment
{
    private const BLOCK_TILE = 2;
    private const PADDLE_TILE = 3;
    private const BALL_TILE = 4;

    private const MOVE_LEFT = -1;
    private const MOVE_RIGHT = 1;
    private const MOVE_NONE = 0;

    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $program = array_map("intval", explode(",", trim($this->getInput())));

        // return answers
        return
            [
                $this->run1($program),
                $this->run2($program)
            ];
    }

    public function run1(array $program): int
    {
        // run the computer to get all its output
        $ic = new IntcodeComputer($program);
        $output = $ic->runToEnd();

        $grid = [];
        // convert the output in chunks to a grid (display pixels)
        foreach (array_chunk($output, 3) as [$x, $y, $c]) {
            $grid[$y][$x] = $c;
        }

        // loop over the grid and count all values
        return array_reduce($grid, static function ($carry, $line) {
            return $carry + array_count_values($line)[self::BLOCK_TILE];
        });
    }

    public function run2(array $program)
    {
        // set the computer to free-play-mode
        $program[0] = 2;

        // create a computer
        $ic = new IntcodeComputer($program);

        $paddle = null;
        $grid = [];
        // loop until done
        while (true) {
            // process one step to get the x coordinate
            $x = $ic->process();

            // if the program ends, break the loop
            if ($x === IntcodeComputer::END_OF_PROGRAM) {
                break;
            }
            // process more steps to get y coordinate and the pixel
            $y = $ic->process();
            $c = $ic->process();

            // draw the pixel in the grid
            $grid[$y][$x] = $c;

            // if we received a paddle location, store the x location
            if ($c === self::PADDLE_TILE) {
                $paddle = $x;
            } elseif ($c === self::BALL_TILE) {
                // if we received the ball location, move the paddle using the input in the computer
                if ($paddle < $x) {
                    // if the paddle is left of the ball, move right
                    $ic->addInput(self::MOVE_RIGHT);
                } elseif ($paddle > $x) {
                    // if the paddle is right of the ball, move left
                    $ic->addInput(self::MOVE_LEFT);
                } else {
                    // if we are exactly at the ball position, than we do not move
                    $ic->addInput(self::MOVE_NONE);
                }
            }
        }

        // return the pixel with the score
        return $grid[0][-1];
    }

}