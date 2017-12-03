<?php

namespace jvwag\AdventOfCode\Year2016;

use jvwag\AdventOfCode\Assignment;

/**
 * Class Day8
 *
 * @package jvwag\AdventOfCode\Year2016
 */
class Day8 extends Assignment
{
    private const MAX_X = 50;
    private const MAX_Y = 6;

    /**
     * @return array
     */
    public function run(): array
    {
        $data = $this->getInput();

        $matrix = array_fill(0, self::MAX_Y, array_fill(0, self::MAX_X, 0));

        foreach (explode("\n", trim($data)) as $line) {
            if (preg_match("/^rect (\d+)x(\d+)$/", $line, $match)) {
                /** @noinspection PhpUnusedLocalVariableInspection */
                [$tmp, $width, $height] = $match;
                for ($x = 0; $x < $width; $x++) {
                    for ($y = 0; $y < $height; $y++) {
                        $matrix[$y][$x] = 1;
                    }
                }

            } elseif (preg_match("/^rotate (row y|column x)=(\d+) by (\d+)$/", $line, $match)) {
                /** @noinspection PhpUnusedLocalVariableInspection */
                [$tmp, $direction, $index, $offset] = $match;
                if ($direction === "row y") {
                    for ($x = 0; $x < $offset; $x++) {
                        array_unshift($matrix[$index], array_pop($matrix[$index]));
                    }
                } else {
                    $arr = [];
                    for ($y = 0; $y < self::MAX_Y; $y++) {
                        $arr[$y] = $matrix[$y][$index];
                    }
                    for ($x = 0; $x < $offset; $x++) {
                        array_unshift($arr, array_pop($arr));
                    }
                    for ($y = 0; $y < self::MAX_Y; $y++) {
                        $matrix[$y][$index] = $arr[$y];
                    }
                }
            }
        }

        $count = 0;
        $output = "";
        foreach ($matrix as $row) {
            $count += array_sum($row);
            $output .= str_replace("0", " ", str_replace("1", "X", implode("", $row))) . PHP_EOL;
        }

        return
            [
                $count,
                $output,
            ];

    }
}
