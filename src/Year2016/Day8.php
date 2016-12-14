<?php
/**
 * Created by PhpStorm.
 * User: Joffrey
 * Date: 12-12-2016
 * Time: 22:53
 */

namespace jvwag\AdventOfCode\Year2016;


use jvwag\AdventOfCode\AssignmentController;
use jvwag\AdventOfCode\AssignmentInterface;

class Day8 extends AssignmentController implements AssignmentInterface
{
    const MAX_X = 50;
    const MAX_Y = 6;

    function run()
    {
        $data = $this->assignment_downloader->getAssignmentData(8);
        $matrix = array_fill(0, self::MAX_Y, array_fill(0, self::MAX_X, 0));

        foreach (explode("\n", trim($data)) as $line) {
            if (preg_match("/^rect ([0-9]+)x([0-9]+)$/", $line, $match)) {
                list(, $width, $height) = $match;
                for ($x = 0; $x < $width; $x++) {
                    for ($y = 0; $y < $height; $y++) {
                        $matrix[$y][$x] = 1;
                    }
                }

            } elseif (preg_match("/^rotate (row y|column x)=([0-9]+) by ([0-9]+)$/", $line, $match)) {
                list(, $direction, $index, $offset) = $match;
                if ($direction == "row y") {
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
        foreach ($matrix as $row) {
            $count += array_sum($row);
        }

        echo $count.PHP_EOL;
        foreach ($matrix as $row) {
            echo str_replace("0", " ", str_replace("1", "X", join("", $row))) . PHP_EOL;
        }
    }
}