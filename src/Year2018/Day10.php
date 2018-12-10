<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2018;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2018
 */
class Day10 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // get input
        $input = explode("\n", trim($this->getInput()));

        $lights = [];

        // parse input by extracting position (x,y) and velocity (x,y) and storing in lights array
        foreach ($input as $line) {
            if (preg_match("/^position=<\s*(-?\d+)\s*,\s*(-?\d+)\s*> velocity=<\s*(-?\d+)\s*,\s*(-?\d+)\s*>$/", $line, $match)) {
                $lights[] = ["pos_x" => (int)$match[1], "pos_y" => (int)$match[2], "vel_x" => (int)$match[3], "vel_y" => (int)$match[4]];
            }
        }

        // init vars
        $steps = 0;
        $height = null;

        // loop to find answer
        do {
            // save previous state
            $prev_height = $height;
            $solved_lights = $lights;

            // loop over lights, adding the velocity, so: making a step
            foreach ($lights as &$light) {
                $light["pos_x"] += $light["vel_x"];
                $light["pos_y"] += $light["vel_y"];
            }
            // unset variable used by reference (to sooth the IDE's piece of mind)
            unset($light);

            // calculate the hight of the solution
            $height = max(array_column($lights, "pos_y"));

            // we stop until we have reached a bigger height compared to the previous step (and count steps)
        } while ($prev_height === null || ($height < $prev_height && ++$steps));

        // return answers
        return
            [
                // we still need some OCR here :)
                $this->plot($solved_lights),
                $steps
            ];
    }

    /**
     * Plot lights in a grid to a string
     *
     * @param int[][] $lights Array of lights containing [pos_x => int, pos_y => int, ...]
     * @return string Lights in a grid
     */
    private function plot($lights): string
    {
        // determine min and max of x and y
        $x_list = array_column($lights, "pos_x");
        $y_list = array_column($lights, "pos_y");
        [$min_x, $max_x, $min_y, $max_y] = [min($x_list), max($x_list), min($y_list), max($y_list)];

        // change lights positions to array key's, so the lookup is more easy
        foreach ($lights as $light) {
            $lpos[$light["pos_x"]][$light["pos_y"]] = true;
        }

        // loop over min_x to max_x and min_y to max_y to create an output grid
        $output = "";
        for ($y = $min_y; $y <= $max_y; $y++) {
            for ($x = $min_x; $x <= $max_x; $x++) {
                // add x for light position and a space for no light
                $output .= isset($lpos[$x][$y]) ? "x" : " ";
            }
            // newline every row
            $output .= PHP_EOL;
        }

        return $output;
    }
}