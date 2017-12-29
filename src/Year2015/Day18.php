<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2015;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2015
 */
class Day18 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // load grid and make 100 steps
        $grid = self::gridLoader($this->getInput());
        $steps = 0;
        while ($steps++ < 100) {
            $grid = self::step($grid);
        }

        // get the sum of the grid for step 1's answer
        $output1 = self::sum($grid);


        // again, load the grid but lock corner lights
        $grid = self::lock(self::gridLoader($this->getInput()));
        $steps = 0;
        while ($steps++ < 100) {
            // after every step, lock the corner lights again
            $grid = self::step($grid);
            $grid = self::lock($grid);
        }

        // get the sum for step 2's answer
        $output2 = self::sum($grid);

        // return answers
        return
            [
                $output1,
                $output2,
            ];
    }

    /**
     * @param string $input
     *
     * @return array
     */
    public static function gridLoader(string $input): array
    {
        $grid = [];
        $grid_size = strpos($input, "\n") ?: 0;
        foreach (str_split(str_replace("\n", "", $input)) as $key => $value) {
            $grid[(int) floor($key / $grid_size)][$key % $grid_size] = $value === "#" ? 1 : 0;
        }

        return $grid;
    }

    /**
     * @param array $grid
     *
     * @return string
     */
    public static function gridSaver(array $grid): string {
        $output = "";
        foreach($grid as $row) {
            $output .= str_replace(["0", "1"], [".", "#"], implode("", $row))."\n";
        }
        return $output;
    }

    /**
     * @param array $old_grid
     *
     * @return array
     */
    public static function step(array $old_grid): array
    {
        $grid_size = \count($old_grid);
        $new_grid = [];
        for ($x = 0; $x < $grid_size; $x++) {
            for ($y = 0; $y < $grid_size; $y++) {
                $neighbors = 0;
                foreach ([[-1, -1], [0, -1], [1, -1], [1, 0], [1, 1], [0, 1], [-1, 1], [-1, 0]] as $neighbor_xy) {
                    $nx = $x + $neighbor_xy[0];
                    $ny = $y + $neighbor_xy[1];

                    if ($nx >= 0 && $nx < $grid_size && $ny >= 0 && $ny < $grid_size) {
                        $neighbors += $old_grid[$nx][$ny];
                    }
                }

                if ($old_grid[$x][$y] === 1) {
                    $new_grid[$x][$y] = ($neighbors === 2 || $neighbors === 3) ? 1 : 0;
                } else {
                    $new_grid[$x][$y] = $neighbors === 3 ? 1 : 0;
                }
            }
        }

        return $new_grid;
    }

    /**
     * @param array $grid
     *
     * @return array
     */
    public static function lock(array $grid): array
    {
        $grid_size = \count($grid);
        $grid[0][0] = $grid[0][$grid_size - 1] = $grid[$grid_size - 1][0] = $grid[$grid_size - 1][$grid_size - 1] = 1;

        return $grid;
    }

    /**
     * @param $grid
     *
     * @return int
     */
    private static function sum($grid): int
    {
        $sum = 0;
        foreach ($grid as $row) {
            $sum += array_sum($row);
        }

        return $sum;
    }
}