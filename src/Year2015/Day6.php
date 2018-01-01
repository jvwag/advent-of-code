<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2015;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2015
 */
class Day6 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        ini_set('memory_limit','512M');

        // convert input
        $lines = \explode("\n", \trim($this->getInput()));

        // init grid
        $grid = \array_fill(0, 1000, array_fill(0, 1000, [0, 0]));

        // loop over all commands
        foreach ($lines as $line) {
            \preg_match("/^(.*) (\d+),(\d+) through (\d+),(\d+)$/", \trim($line), $match);
            /** @todo remove noinspection and $tmp after fix for https://youtrack.jetbrains.com/issue/WI-34517 */
            /** @noinspection PhpUnusedLocalVariableInspection */
            [$tmp, $cmd, $x1, $y1, $x2, $y2] = $match;

            // loop over the given square and changes values on the grid
            for ($x = $x1; $x <= $x2; $x++) {
                for ($y = $y1; $y <= $y2; $y++) {
                    switch ($cmd) {
                        case "turn on":
                            $grid[$x][$y][0] = 1;
                            $grid[$x][$y][1]++;
                            break;

                        case "turn off":
                            $grid[$x][$y][0] = 0;
                            $grid[$x][$y][1] = max($grid[$x][$y][1] - 1, 0);

                            break;

                        case "toggle":
                            $grid[$x][$y][0] = ($grid[$x][$y][0] + 1) % 2;
                            $grid[$x][$y][1] += 2;
                            break;
                    }
                }
            }
        }

        // find output by counting the grid
        $c1 = $c2 = 0;
        foreach ($grid as $x => $row) {
            foreach ($row as $y => $cell) {
                $c1 += $cell[0];
                $c2 += $cell[1];
            }
        }

        // return answers
        return
            [
                $c1,
                $c2,
            ];
    }
}