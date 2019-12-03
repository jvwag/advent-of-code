<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2019;

use jvwag\AdventOfCode\Assignment;
use Psr\Log\LoggerInterface;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2019
 */
class Day3 extends Assignment
{
    private const DIR = ["R" => [1, 0], "D" => [0, -1], "L" => [-1, 0], "U" => [0, 1]];

    public function __construct(LoggerInterface $logger = null)
    {
        parent::__construct($logger);

        // this solution needs a bit more memory :)
        ini_set("memory_limit", "256M");
    }

    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $loops = array_map(static function ($arr) {
            return explode(",", $arr);
        }, explode("\n", trim($this->getInput())));

        // calculate two answers
        $output = $this->calc($loops);

        // return answers
        return
            [
                $output[0], // manhattan distance to nearest intersection
                $output[1], // combined length of path to intersection with shortest path
            ];
    }

    /**
     * @param array $loops
     * @return int[]
     */
    public function calc(array $loops): array
    {
        // init grid
        $grid = [];

        // init output values, the result will always be smaller than our max int value
        // its easier to init here than check for existence in the nested loop
        $distance = $min_steps = PHP_INT_MAX;

        // loop over the two routes, and indicate the route number with $l
        foreach ($loops as $l => $routes) {
            $x = $y = $steps = 0;
            // loop over the route directions
            foreach ($routes as $route) {
                // decode the direction: $dir will be a letter (see const's) and length the amount to step
                [$dir, $length] = [$route[0], (int)substr($route, 1)];

                // step the amount of steps given
                for ($i = 0; $i < $length; $i++) {
                    // and move our x,y to the proper direction
                    $x += self::DIR[$dir][0];
                    $y += self::DIR[$dir][1];
                    // and mark on the grid where we have been, and the number of steps at that moment
                    $grid[$x][$y][$l] = ++$steps;

                    // if there are two entries on the grid we found a crossing point between the two lines
                    if (count($grid[$x][$y]) === 2) {
                        // calculate the minimum distance (manhattan distance)
                        $distance = min($distance, abs($x) + abs($y));
                        // calculate the sum of the two steps
                        $min_steps = min($min_steps, array_sum($grid[$x][$y]));
                    }
                }
            }
        }

        return [$distance, $min_steps];
    }
}