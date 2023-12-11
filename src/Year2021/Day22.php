<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2021;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2021
 */
class Day22 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $grid = [];
        foreach (explode("\n", trim($this->getInput())) as $line) {
            if (preg_match("/^(on|off) x=(-?\d+)\.\.(-?\d+),y=(-?\d+)\.\.(-?\d+),z=(-?\d+)\.\.(-?\d+)$/", $line, $match)) {
                array_shift($match);
                $state = array_shift($match) === "on";
                [$min_x, $max_x, $min_y, $max_y, $min_z, $max_z] = array_map("intval", $match);
                if ($min_x >= -50 && $max_x <= 50 && $min_y >= -50 && $max_y <= 50 && $min_z >= -50 && $max_z <= 50) {
                    for ($x = $min_x; $x <= $max_x; $x++) {
                        for ($y = $min_y; $y <= $max_y; $y++) {
                            for ($z = $min_z; $z <= $max_z; $z++) {
                                $grid[$x][$y][$z] = $state;
                            }
                        }
                    }
                }
            }
        }

        $cube_coordinates_lit = array_reduce($grid, function ($carry, $x_list) {
            return $carry + array_reduce($x_list, function ($carry, $y_list) {
                    return $carry + array_reduce($y_list, function ($carry, $element) {
                            return $carry + (int)($element);
                        });
                });
        });

        $output2 = null;

        foreach (explode("\n", trim($this->getInput())) as $line) {
            if (preg_match("/^(on|off) x=(-?\d+)\.\.(-?\d+),y=(-?\d+)\.\.(-?\d+),z=(-?\d+)\.\.(-?\d+)$/", $line, $match)) {
                array_shift($match);
                $state = array_shift($match) === "on";
                [$min_x, $max_x, $min_y, $max_y, $min_z, $max_z] = array_map("intval", $match);
                if ($min_x >= -50 && $max_x <= 50 && $min_y >= -50 && $max_y <= 50 && $min_z >= -50 && $max_z <= 50) {
                    if($state) {

                    }
                }
            }
        }


        // return answers
        return
            [
                $cube_coordinates_lit,
                $output2
            ];
    }
}