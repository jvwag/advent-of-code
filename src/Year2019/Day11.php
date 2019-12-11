<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2019;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2019
 */
class Day11 extends Assignment
{
    private const BLACK = 0;
    private const WHITE = 1;

    private const UP = 0;
    private const RIGHT = 1;
    private const DOWN = 2;
    private const LEFT = 3;

    /** @var int[][] */
    private const STEP = [self::UP => [0, -1], self::RIGHT => [1, 0], self::DOWN => [0, 1], self::LEFT => [-1, 0]];


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
                $this->run2($program),
            ];
    }

    public function run1(array $program): int
    {
        // calculate program with input 0
        $grid = $this->calculate($program, 0);

        // sum all painted items in grid (sum the count of all row contents)
        return array_reduce($grid, static function ($carry, $line) {
            return $carry + count($line);
        });
    }

    public function run2(array $program): string
    {
        // calculate program with input 1
        $grid = $this->calculate($program, 1);

        $output = "";
        // determine max size of coordinates in grid
        $max_x = max(array_keys($grid));
        $max_y = array_reduce($grid, static function ($carry, $line) {
            return max($carry, ...array_keys($line));
        });

        // loop over grid
        for ($y = 0; $y <= $max_y; $y++) {
            for ($x = 0; $x <= $max_x; $x++) {
                // draw a character
                $output .= $grid[$x][$y] === self::WHITE ? "\u{2588}" : " ";
            }
            // strip trailing spaces of the line, and add a newline
            $output = rtrim($output) . PHP_EOL;
        }

        // return output
        return rtrim($output);
    }

    private function calculate(array $program, int $input): array
    {
        // we take a new computer
        $ic = new IntcodeComputer($program);
        // init coords and direction
        $x = $y = 0;
        $dir = self::UP;

        // set the initial cell color
        $grid = [0 => [0 => $input]];

        // loop until program ends
        while (true) {
            // add the input of the grid contents, default panels are black
            $ic->addInput($grid[$x][$y] ?? self::BLACK);

            // if program ends, break this loop
            if (($color = $ic->process()) === null) {
                break;
            }

            // set the grid color
            $grid[$x][$y] = $color;

            // determine new direction: 0 is turn left, 1 is turn right
            $dir = (4 + $dir + ($ic->process() === 0 ? -1 : 1)) % 4;

            // increment the coordinates based on the direction
            $x += self::STEP[$dir][0];
            $y += self::STEP[$dir][1];

        }

        return $grid;
    }
}