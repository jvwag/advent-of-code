<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2020;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2020
 */
class Day12 extends Assignment
{
    const NORTH = 0;
    const EAST = 1;
    const SOUTH = 2;
    const WEST = 3;

    const DIRS = [self::NORTH => [0, -1], self::EAST => [1, 0], self::SOUTH => [0, 1], self::WEST => [-1, 0],];
    const DIRS_LOOKUP = ["N" => self::NORTH, "E" => self::EAST, "S" => self::SOUTH, "W" => self::WEST];

    /**
     * @return array
     */
    public function run(): array
    {
        // parse the route
        $route = array_map(
            fn($s) => [ // return an array with two elements
                substr($s, 0, 1), // first character of the line
                intval(substr($s, 1)) // int value of the rest of the line
            ],
            explode("\n", trim($this->getInput()))
        );

        // part 1
        // set direction to EAST and ship at 0,0
        $dir = self::EAST;
        $ship_x = $ship_y = 0;
        // loop over the route and process each action/value pair
        foreach ($route as [$action, $value]) {
            switch ($action) {
                // in the case of left and right instructions: change direction and exit the loop for this action
                case "L":
                    $dir = ($dir + 4 - ($value / 90)) % 4;
                    continue 2;
                case "R":
                    $dir = ($dir + 4 + ($value / 90)) % 4;
                    continue 2;
                // in case of forward: we will use the current direction
                case "F":
                    $step_dir = $dir;
                    break;
                // in all other cases, we will use direction given by the action
                default:
                    // this will lookup the action letter with the correct direction
                    $step_dir = self::DIRS_LOOKUP[$action];
            }

            // now we have determined our direction, make the step with the ship
            $ship_x += self::DIRS[$step_dir][0] * $value;
            $ship_y += self::DIRS[$step_dir][1] * $value;
        }
        // the result is the manhattan-value of the ships location in the grid
        $output1 = abs($ship_x) + abs($ship_y);

        // part 2
        // set the ships location at 10,10 and the initial waypoint to 10,-1
        $ship_x = $ship_y = 0;
        // the waypoint is always relative to the ship (its origin)
        $waypoint_x = 10;
        $waypoint_y = -1;
        foreach ($route as [$action, $value]) {
            switch ($action) {
                // in the first four cases we just move the waypoint given the value
                case "N";
                    $waypoint_y -= $value;
                    break;
                case "E":
                    $waypoint_x += $value;
                    break;
                case "S":
                    $waypoint_y += $value;
                    break;
                case "W":
                    $waypoint_x -= $value;
                    break;
                // in the case of a left or right turn, rotate the waypoint around the origin based on its value
                case "L":
                    [$waypoint_x, $waypoint_y] = $this->rotate($waypoint_x, $waypoint_y, -$value); // counter-clockwise
                    break;
                case "R":
                    [$waypoint_x, $waypoint_y] = $this->rotate($waypoint_x, $waypoint_y, +$value); // clockwise
                    break;
                // or, if a forward action, move the ship to the waypoint for the amount of times given by the value
                case "F":
                    $ship_x += $waypoint_x * $value;
                    $ship_y += $waypoint_y * $value;
                    break;
            }
        }
        // the result is the manhattan-value of the ships location in the grid
        $output2 = abs($ship_x) + abs($ship_y);


        // return answers
        return
            [
                $output1,
                $output2
            ];
    }

    /**
     * Fast but limited function to rotate a coordinate around its origin. Does only
     * support rotations in steps of 90 degrees, from -270 to 270. All other values
     * will return a rotation of 0 degrees.
     *
     * @param int $x X coordinate
     * @param int $y Y coordinate
     * @param int $degrees Degrees (can only be -270, -180, -90, 90, 180 or 270)
     * @return int[] With two elements, the rotated X coordinate and Y coordinate
     */
    private function rotate(int $x, int $y, int $degrees): array
    {
        [$out_x, $out_y] = [$x, $y];
        switch ($degrees) {
            case 90:
            case -270:
                $out_x = $y * -1;
                $out_y = $x;
                break;
            case 180:
            case -180:
                $out_x = $x * -1;
                $out_y = $y * -1;
                break;
            case -90:
            case 270:
                $out_x = $y;
                $out_y = $x * -1;
                break;
        }

        return [intval($out_x), intval($out_y)];
    }
}