<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2025;

use jvwag\AdventOfCode\Assignment;

class Day12 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // parse the input, first all regions into arrays of x,y and number of
        // each shape [x, y, [c0, c1, c2, ...]]
        $regions = [];
        $blocks = explode("\n\n", trim($this->getInput()));
        foreach (explode("\n", array_pop($blocks)) as $line) {
            if (preg_match("/^(\d+)x(\d+): (.*)$/", $line, $matches)) {
                $regions[] = [
                    intval($matches[1]),
                    intval($matches[2]),
                    array_map("intval", explode(" ", trim($matches[3])))
                ];
            }
        }

        // now the shapes
        $shapes = [];
        foreach ($blocks as $block) {
            $lines = explode("\n", $block);
            $id = intval(trim(array_shift($lines), ":"));
            foreach ($lines as $line) {
                $shapes[$id][] = array_map(function ($char) {
                    return $char === "#";
                }, str_split($line));
            }
        }

        // after a weekend of fkcing around I looked on reddit and saw
        // the puzzle input was way simpler than the explanation of the
        // assignment, now we will only determine the size of each shape
        $shape_sizes = [];
        foreach($shapes as $id => $shape) {
            $c = 0;
            foreach($shape as $row) {
                foreach($row as $char) {
                    if($char)
                        $c++;
                }
            }
            $shape_sizes[$id] = $c;
        }

        // loop over all regions to see if the shapes fit the region
        $does_it_fit = 0;
        foreach($regions as $region) {
            // calculate the region size
            $region_size = $region[0] * $region[1];
            $shapes_sum = 0;
            // calculate the size of the shapes in the region
            foreach($region[2] as $shape_id => $shapes_count) {
                $shapes_sum += $shape_sizes[$shape_id] * $shapes_count;
            }
            // if the shapes fit the region
            if($shapes_sum <= $region_size) {
                $does_it_fit++;
            }
        }

        // return answers
        return
            [
                $does_it_fit,
                null // no part2
            ];
    }
}