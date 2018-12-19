<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2018;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2018
 */
class Day17 extends Assignment
{
    /** @var string Clay character */
    public const CLAY = "#";

    /** @var string Sand character */
    public const SAND = ".";

    /** @var string Flowing water character */
    public const FLOW = "|";

    /** @var string Resting water character */
    public const REST = "~";

    /** @var int Right */
    public const LEFT = -1;

    /** @var int Left */
    public const RIGHT = 1;

    /** @var int Start X */
    public const START_X = 500;

    /** @var int Start Y */
    public const START_Y = 0;

    /**
     * @return array
     */
    public function run(): array
    {
        // parse input and place clay veins
        $grid = [];
        foreach (explode("\n", trim($this->getInput())) as $line) {
            if (preg_match("/^([xy])=(\d+), [xy]=(\d+)\.\.(\d+)$/", $line, $match)) {
                [, $type, $p1, $p2, $p3] = $match;
                for ($i = $p2; $i <= $p3; $i++) {
                    if ($type === "x") {
                        $grid[$i][$p1] = self::CLAY;
                    } else {
                        $grid[$p1][$i] = self::CLAY;
                    }
                }
            }
        }

        // determine the minimum y value where clay is present
        $min_y = min(array_keys($grid));
        $max_y = max(array_keys($grid));

        // flow through the grid
        $this->flow(self::START_Y, self::START_X, $grid, $max_y);

        // reduce the size of the grid: the top rows without clay do not count in the scoring
        /** @noinspection ForeachInvariantsInspection */
        for ($i = 0; $i < $min_y; $i++) {
            unset($grid[$i]);
        }

        // count all characters in the grid
        $count_values_part1 = array_count_values(array_merge(...$grid));

        // return answers
        return
            [
                ($count_values_part1[self::REST] ?? 0) + ($count_values_part1[self::FLOW] ?? 0), // sum of all types of water
                $count_values_part1[self::REST] ?? 0, // all resting water
            ];
    }


    /**
     * Flow water
     *
     * @param int $y Y Starting position
     * @param int $x X Starting position
     * @param array $grid Grid of (y,x) characters [|,~,#]
     * @param int $max_y Maximum Y value of flow
     */
    public function flow(int $y, int $x, array &$grid, int $max_y): void
    {
        // keep falling down until we hit something
        while (true) {
            // what tile lies below our current position?
            $below = $grid[$y + 1][$x] ?? self::SAND;

            // if we hit clay, we break going down
            if ($below === self::CLAY) {
                break;
            }

            // if we hit flowing water, we stop processing this flow
            if ($below === self::FLOW) {
                return;
            }

            // if we hit the bottom of the grid, we stop processing this flow
            if ($y >= $max_y) {
                return;
            }

            // mark the tile below as flowing water, and descent the next depth
            $grid[++$y][$x] = self::FLOW;
        }

        // loop until we have found what to do to our left and right side
        while (true) {

            $adjacent = $steps = [self::LEFT => null, self::RIGHT => null];

            // loop in two directions left(-1) and right(+1)
            foreach ([self::LEFT, self::RIGHT] as $direction) {
                $i = 1;
                // loop until we have found something
                while (true) {
                    // x position, left/right
                    $steps[$direction] = $x + ($i * $direction);
                    // adjacent character
                    $adjacent[$direction] = $grid[$y][$steps[$direction]] ?? self::SAND;

                    // if it is a wall, we are done looking
                    if ($adjacent[$direction] === self::CLAY) {
                        break;
                    }

                    // or adjacent tile is not resting water, we mark it as flowing water
                    if ($adjacent[$direction] !== self::REST) {
                        $grid[$y][$steps[$direction]] = self::FLOW;
                    }

                    // lookup the tile below
                    $below = $grid[$y + 1][$steps[$direction]] ?? self::SAND;

                    // if the tile below is a flow, we will stop here, another function is already processing this
                    if ($below === self::FLOW) {
                        break;
                    }

                    // if it is sand, we will need to drop down
                    if ($below === self::SAND) {
                        // so we call flow recursively, but now from this position
                        $this->flow($y, $steps[$direction], $grid, $max_y);
                        break;
                    }
                    $i++;
                }
            }

            // if the left and right lookups found two clay tiles, we need to convert flowing water to resting water
            if ($adjacent[self::LEFT] === self::CLAY && $adjacent[self::RIGHT] === self::CLAY) {
                // loop over most left step, to the most right step
                for ($i = $steps[self::LEFT] + 1; $i <= $steps[self::RIGHT] - 1; $i++) {
                    // set this position to resting water
                    $grid[$y][$i] = self::REST;
                }

                // mark the position above our current position as flowing, and ascent one level
                $grid[--$y][$x] = self::FLOW;
            } else {
                // if there were no clay tiles, we are stopping the horizontal search
                break;
            }
        }
    }
}