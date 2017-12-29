<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2016;

use jvwag\AdventOfCode\Assignment;

/**
 * Class Day2
 *
 * @package jvwag\AdventOfCode\Year2016
 */
class Day2 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        $data = $this->getInput();

        $numbers1 = [];
        $numbers2 = [];

        $num1 = 5;
        $num2 = 5;
        foreach (explode("\n", trim($data)) as $seq) {
            $seq = trim($seq);
            foreach (str_split($seq) as $direction) {
                $num1 = $this->nextNumberSimple($num1, $direction);
                $num2 = $this->nextNumberComplex($num2, $direction);
            }

            $numbers1[] = $num1;
            $numbers2[] = $num2;
        }

        return
            [
                implode("", $numbers1),
                strtoupper(implode("", $numbers2)),
            ];
    }

    /**
     * @param $num
     * @param $direction
     *
     * @return bool|int
     */
    public function nextNumberSimple($num, $direction)
    {
        switch ($direction) {
            case "U":
                return $num - ($num > 3 ? 3 : 0);
            case "D":
                return $num + ($num < 7 ? 3 : 0);
            case "L":
                return $num - ((($num - 1) % 3) !== 0 ? 1 : 0);
            case "R":
                return $num + (($num % 3) !== 0 ? 1 : 0);
        }

        return \assert(false, "Invalid move");
    }

    /**
     * @param $num
     * @param $direction
     *
     * @return string
     */
    public function nextNumberComplex($num, $direction): string
    {
        $num = hexdec($num);
        switch ($direction) {
            case "U":
                if (\in_array($num, [1, 2, 4, 5, 9], true)) {
                    $num -= 0;
                } elseif (\in_array($num, [6, 7, 8, 10, 11, 12], true)) {
                    $num -= 4;
                } elseif (\in_array($num, [3, 13], true)) {
                    $num -= 2;
                } else {
                    \assert(false, "Illegal U");
                }
                break;
            case "D":
                if (\in_array($num, [5, 9, 10, 12, 13], true)) {
                    $num += 0;
                } elseif (\in_array($num, [2, 3, 4, 6, 7, 8], true)) {
                    $num += 4;
                } elseif (\in_array($num, [1, 11], true)) {
                    $num += 2;
                } else {
                    \assert(false, "Illegal D");
                }
                break;
            case "L":
                if (\in_array($num, [1, 2, 5, 10, 13], true)) {
                    $num -= 0;
                } elseif (\in_array($num, [3, 4, 6, 7, 8, 9, 11, 12], true)) {
                    $num -= 1;
                } else {
                    \assert(false, "Illegal L");
                }
                break;
            case "R":
                if (\in_array($num, [1, 4, 9, 12, 13], true)) {
                    $num += 0;
                } elseif (\in_array($num, [2, 3, 5, 6, 7, 8, 10, 11], true)) {
                    $num += 1;
                } else {
                    \assert(false, "Illegal L");
                }
                break;
            default:
                \assert(false, "Illegal move");
        }

        return dechex($num);
    }
}
