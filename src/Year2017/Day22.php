<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2017;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2017
 */
class Day22 extends Assignment
{
    private const UP = 0;
    private const RIGHT = 1;
    private const DOWN = 2;
    private const LEFT = 3;

    private const STATE_CLEAN = ".";
    private const STATE_WEAKENED = "W";
    private const STATE_FLAGGED = "F";
    private const STATE_INFECTED = "#";

    private const GO_LEFT = -1;
    private const GO_FORWARD = 0;
    private const GO_RIGHT = 1;
    private const GO_BACK = 2;

    /**
     * @return array
     */
    public function run(): array
    {
        // read the grid
        $grid = $this->readGrid();

        // return answers
        return
            [
                $this->run1($grid, 10000), // simple infection cycle with 10k cycles
                $this->run2($grid, 10000000), // more complex infection cycle with 10M cycles
            ];
    }

    /**
     * Read Grid from Input
     *
     * @return array[] Two dimensional array with x as first key and y as second, c
     *                 ontains '.' for clean and '#' for infected spaces as elements
     */
    public function readGrid(): array
    {
        // convert input
        $lines = \explode("\n", \trim($this->getInput()));

        // determine height and width
        $height = \count($lines);
        $width = \strlen($lines[0]);

        // form grid
        $grid = [];
        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                // make the center of the given grid 0,0
                $grid[$x - (int)floor($width / 2)][$y - (int)floor($height / 2)] = $lines[$y][$x];
            }
        }

        // return grid
        return $grid;
    }

    /**
     * Counts every state change to infected give the grid and a number of bursts
     *
     * @param array[] $grid Two dimensional array containing the infection grid
     * @param int $bursts Number of bursts (cycles) for the virus
     * @return int Number of states changed to infected
     */
    public function run1($grid, $bursts): int
    {
        // init vars
        $x = 0;
        $y = 0;
        $direction = 0;
        $infected = 0;

        // loop over bursts
        for ($i = 0; $i < $bursts; $i++) {
            // init grid space if not set
            if (!isset($grid[$x][$y])) {
                $grid[$x][$y] = self::STATE_CLEAN;
            }

            // determine node state
            $clean = $grid[$x][$y] === self::STATE_CLEAN;

            // up infected counter
            $infected += $clean ? 1 : 0;

            // calculate new direction
            $direction = (4 + $direction + ($clean ? self::GO_LEFT : self::GO_RIGHT)) % 4;

            // toggle node
            $grid[$x][$y] = $clean ? self::STATE_INFECTED : self::STATE_CLEAN;

            // @formatter:off
            // update coordinates based on direction
            switch ($direction) {
                case self::UP:    $y--; break;
                case self::RIGHT: $x++; break;
                case self::DOWN:  $y++; break;
                case self::LEFT:  $x--; break;
            }
            // @formatter:on
        }

        // return infected state changes
        return $infected;
    }

    /**
     * Counts every state change to infected give the grid and a number of bursts
     *
     * This part of the answer has a more complex state change
     *
     * @param array[] $grid Two dimensional array containing the infection grid
     * @param int $bursts Number of bursts (cycles) for the virus
     * @return int Number of states changed to infected
     */
    public function run2($grid, $bursts): int
    {
        // init vars
        $x = 0;
        $y = 0;
        $direction = 0;
        $infected = 0;

        // loop over bursts
        for ($i = 0; $i < $bursts; $i++) {
            // init grid space if not set
            if (!isset($grid[$x][$y])) {
                $grid[$x][$y] = self::STATE_CLEAN;
            }

            // determine node state
            $state = $grid[$x][$y];

            // up infected counter
            $infected += $state === self::STATE_WEAKENED ? 1 : 0;

            // calculate new direction
            $new_direction = null;
            switch ($state) {
                case self::STATE_CLEAN:
                    $new_direction = self::GO_LEFT;
                    $grid[$x][$y] = self::STATE_WEAKENED;
                    break;
                case self::STATE_WEAKENED:
                    $new_direction = self::GO_FORWARD;
                    $grid[$x][$y] = self::STATE_INFECTED;
                    break;
                case self::STATE_INFECTED:
                    $new_direction = self::GO_RIGHT;
                    $grid[$x][$y] = self::STATE_FLAGGED;
                    break;
                case self::STATE_FLAGGED:
                    $new_direction = self::GO_BACK;
                    $grid[$x][$y] = self::STATE_CLEAN;
                    break;
            }

            // calculate new direction
            $direction = (4 + $direction + $new_direction) % 4;

            // update coordinates based on direction
            // @formatter:off
            switch ($direction) {
                case self::UP:    $y--; break;
                case self::RIGHT: $x++; break;
                case self::DOWN:  $y++; break;
                case self::LEFT:  $x--; break;
            }
            // @formatter:on
        }

        // return infected state changes
        return $infected;
    }
}