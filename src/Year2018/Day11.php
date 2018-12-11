<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2018;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2018
 */
class Day11 extends Assignment
{
    /** @var int Minimum X of grid */
    private const MIN_X = 1;

    /** @var int Maximum X of grid */
    private const MAX_X = 300;

    /** @var int Minimum Y of grid */
    private const MIN_Y = 1;

    /** @var int Maximum Y of grid */
    private const MAX_Y = 300;

    /** @var int Default Square Size for part one */
    private const DEFAULT_SQUARE_SIZE = 3;

    /** @var int Magic number to add on the last step of calculating a grid cell */
    private const MAGIC_FIVE = 5;

    /** @var int Magic offset for calculating a rack id */
    private const MAGIC_X_OFFSET = 10;

    /** @var int Magic digit number for calculating a grid cell */
    private const MAGIC_DIGIT_NUMBER = 3;

    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $serial_number = (int)trim($this->getInput());

        // calculate a grid based on the input serial number
        $grid = $this->calculateGrid($serial_number);

        // find answer for part one by finding the highest 3x3 square
        $output1 = $this->findSquare($grid, [self::DEFAULT_SQUARE_SIZE]);
        // and for part two by doing all possible square sizes
        $output2 = $this->findSquare($grid, range(self::MIN_X, self::MAX_X));

        // return answers
        return
            [
                implode(",", [$output1["x"], $output1["y"]]),
                implode(",", [$output2["x"], $output2["y"], $output2["square_size"]]),
            ];
    }

    /**
     * Create a grid based on a serial number
     *
     * @param int $serial_number
     * @return array
     */
    public function calculateGrid(int $serial_number): array
    {
        $grid = [];
        // loop over all coordinates
        for ($y = self::MIN_Y; $y <= self::MAX_Y; $y++) {
            for ($x = self::MIN_X; $x <= self::MAX_X; $x++) {

                // rack-id is the x position plus a magic offset
                $rack_id = $x + self::MAGIC_X_OFFSET;
                // the initial power level is the rack-id times the y coordinate
                $power_level = $rack_id * $y;
                // add the serial number (this is the personal input)
                $power_level += $serial_number;
                // now multiplying by the rack-id
                $power_level *= $rack_id;
                // take the 3rd digit
                $power_level = (int)(substr((string)$power_level, -self::MAGIC_DIGIT_NUMBER, 1) ?? 0);
                // and subtract a 5, because: why not...
                $power_level -= self::MAGIC_FIVE;

                // set this power level to the grid
                $grid[$x][$y] = $power_level;
            }
        }

        // and return the grid
        return $grid;
    }

    public function findSquare($grid, $squares)
    {
        $grid_sum = [];
        // first, loop over the complete grid, back to front
        for ($y = self::MAX_Y; $y >= self::MIN_Y; $y--) {
            for ($x = self::MAX_X; $x >= self::MIN_X; $x--) {
                // calculate, per cell, the sum of all values of the current cell and all cells that
                // are located right (>x) and below (>y) by:
                $grid_sum[$x][$y] =
                    $grid[$x][$y] // taking the current number, and taking the previous calculated sums (if exist):
                    + ($grid_sum[$x + 1][$y] ?? 0) // adding sum from the column to the right
                    + ($grid_sum[$x][$y + 1] ?? 0) // adding sum from the row below
                    - ($grid_sum[$x + 1][$y + 1] ?? 0); // subtracting the sum from the cell one below and one right
            }
        }

        $output = ["sum" => 0];
        // now we loop over all our square sizes
        foreach ($squares as $square_size) {
            // and over all coordinates in the grid
            for ($y = self::MIN_Y; $y <= self::MAX_Y - $square_size + 1; $y++) {
                for ($x = self::MIN_X; $x <= self::MAX_X - $square_size + 1; $x++) {
                    // and determining the sum, by adding and subtracting the sum on the current coordinate
                    // and the sums of the value just outside of our squares:
                    $sum =
                        $grid_sum[$x][$y] // the current sum, and from sums just outside of the given square (if exists):
                        - ($grid_sum[$x + $square_size][$y] ?? 0) // subtracting the sum from the cell below, just outside our square on the same column
                        - ($grid_sum[$x][$y + $square_size] ?? 0) // subtracting the sum from the cell right, just outside our square on the same row
                        + ($grid_sum[$x + $square_size][$y + $square_size] ?? 0); // adding the sum from the cell one below and one right just outside of our squares most right-bottom corner

                    // now we see if this sum is the largest we got, and save the output if it is
                    if ($sum > $output["sum"]) {
                        $output = ["x" => $x, "y" => $y, "square_size" => $square_size, "sum" => $sum];
                    }
                }
            }
        }

        // return location and size of the largest square that can be found in the grid
        return $output;
    }
}