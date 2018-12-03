<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2018;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2018
 */
class Day3 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        $output1 = null;
        $output2 = null;

        // read input
        /** @noinspection PhpUnusedLocalVariableInspection */
        $input = $this->getInput();

        // convert input to clams
        $claims = [];
        foreach (explode("\n", trim($input)) as $line) {
            $e = [];
            if (preg_match("/^#(\d+) @ (\d+),(\d+): (\d+)x(\d+)$/", $line, $match)) {
                //format claim[id] = [x,y,w(idth),h(eight)]
                [, $id, $e["x"], $e["y"], $e["w"], $e["h"]] = $match;

                // convert vars to int's
                $e = array_map("intval", $e);

                // fill claims array:
                $claims[(int)$id] = $e;
            }
        }

        // the solution of part 1 is the number over overlapping inches of all claims
        $output1 = $this->calculateOverlap($claims);

        // for part 2 we will loop over all claim combinations, and removing those who have overlapping claims
        while (count($claims) > 1) {
            foreach($claims as $k1 => $e1) {
                foreach($claims as $k2 => $e2) {
                    // do not compare the same claims
                    if ($e1 !== $e2 && $this->calculateOverlap([$e1, $e2])) {
                        // if overlap, unset the two claims from the list
                        unset($claims[$k1], $claims[$k2]);
                    }
                }
            }
        }

        // the last standing claim must be the solution to part 2
        $output2 = key($claims);

        // return answers
        return
            [
                $output1,
                $output2
            ];
    }

    /**
     * Given two or more claims, calculate the number of square inches overlap
     *
     * @param int[][] $claims Array of elements (claim[id] = [x,y,w(idth),h(eight)])
     * @return int
     */
    private function calculateOverlap(array $claims): int
    {
        $fabric = [];
        // first, plot all claims in an matrix
        foreach ($claims as $e) {
            for ($x = $e["x"]; $x < $e["x"] + $e["w"]; $x++) {
                for ($y = $e["y"]; $y < $e["y"] + $e["h"]; $y++) {
                    // if key does not exist, create one
                    if (!isset($fabric[$x][$y])) {
                        $fabric[$x][$y] = 1;
                    } else {
                        // or add one
                        $fabric[$x][$y]++;
                    }
                }
            }

        }

        $overlap = 0;
        // now find all fields where there was overlap, and count those fields
        foreach ($fabric as $x => $rows) {
            foreach ($rows as $y => $column) {
                if ($column > 1) {
                    $overlap++;
                }

            }
        }

        // return the number of overlapping fields
        return $overlap;
    }
}