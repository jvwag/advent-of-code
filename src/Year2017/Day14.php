<?php

namespace jvwag\AdventOfCode\Year2017;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2017
 */
class Day14 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        $grid = "";

        // convert input
        $input = trim($this->getInput());

        // use the day10 solution
        $day10 = new Day10();

        // loop over 128 rows
        for ($x = 0; $x < 128; $x++) {
            // create a 128 bit hash over a specific input
            $hash = $day10->run2($input . "-" . $x);
            // format the hash binary and add to the grid
            foreach (str_split($hash, 2) as $byte) {
                $grid .= sprintf("%08b", hexdec($byte));
            }
        }

        $used_space = substr_count($grid, "1");

        // find all regions
        $regions = 0;
        // loop over grid to find used space
        for ($x = 0; $x < 128 * 128; $x++) {
            // when found, add a region
            if ($grid[$x] === "1") {
                $regions++;
                // find all adjacent used space
                $arr = $this->findRegion($x, $grid);
                // replace the 1 in the grid with a x to mark this is done
                foreach ($arr as $i) {
                    $grid[$i] = "x";
                }
            }
        }

        // return answers
        return
            [
                $used_space, // number of used elements in the grid
                $regions, // number of regions found
            ];
    }

    /**
     * Find all free space in a region
     *
     * @param int $x Start location
     * @param string $grid Grid
     * @param array $found Internal memory for found locations
     * @return int[] Locations in this region
     */
    public function findRegion($x, $grid, &$found = [])
    {
        // add this location to list of found locations
        $found[$x] = $x;

        // get all locations around our starting point
        foreach ($this->findaround($x) as $i) {
            // and if its used, and not already found
            if($grid[$i] === "1" && !isset($found[$i])) {
                // recursively find that new location
                foreach($this->findRegion($i, $grid, $found) as $f) {
                    // and merge all found locations
                    $found[$f] = $f;
                }
            }
        }

        // return our found location
        return $found;
    }

    /**
     * Find all valid locations around one location
     *
     * @param int $x Location
     * @param int $size Size of grid
     * @return int[] Array of valid locations around location
     */
    public function findAround($x, $size = 128)
    {
        $arr = [];
        // valid location to the right?
        if($x % $size > 0) {
            $arr[] = $x - 1;
        }
        // valid location to the left?
        if($x % $size < $size - 1) {
            $arr[] = $x + 1;
        }
        // valid location above?
        if($x >= $size) {
            $arr[] = $x - $size;
        }
        // valid location below?
        if($x < ($size * ($size - 1))) {
            $arr[] = $x + $size;
        }
        // sort for reliable unit tests
        sort($arr);

        // return possible locations
        return $arr;
    }
}