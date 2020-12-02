<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2015;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2015
 */
class Day15 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        ini_set('memory_limit','512M');

        // get lines
        $lines = explode("\n", trim($this->getInput()));


        // fill ingredient data
        $data = [];
        foreach ($lines as $line) {
            if (preg_match("#^(.+): capacity (-?\d+), durability (-?\d+), flavor (-?\d+), texture (-?\d+), calories (-?\d+)$#", $line, $match)) {
                $data[] = ["name" => $match[1], "capacity" => (int) $match[2], "durability" => (int) $match[3], "flavor" => (int) $match[4], "texture" => (int) $match[5], "calories" => (int) $match[6]];
            }
        }

        // init vars
        $scores1 = $scores2 = [];

        // loop over all possible combinations of ingredients to 100 teaspoons
        foreach ($this->multiChoose(100, count($data)) as $dist) {

            // loop over the ingredients to add all scores based on the distribution
            $capacity = $durability = $flavor = $texture = $calories = 0;
            foreach ($dist as $key => $amount) {
                $capacity += $data[$key]["capacity"] * $amount;
                $durability += $data[$key]["durability"] * $amount;
                $flavor += $data[$key]["flavor"] * $amount;
                $texture += $data[$key]["texture"] * $amount;
                $calories += $data[$key]["calories"] * $amount;
            }

            // sum the score
            $score = max(0, $capacity) * max(0, $durability) * max(0, $flavor) * max(0, $texture);

            // part two looks for '500 calorie' cookies
            if ($calories === 500) {
                $scores2[] = $score;
            }

            $scores1[] = $score;
        }

        // return answers
        return
            [
                max($scores1),
                max($scores2)
            ];
    }

    /**
     * gives all permutations given a total, and types of values
     *
     * @param int $k total
     * @param int $n types
     *
     * @return array|bool
     */
    private function multiChoose(int $k, int $n)
    {
        $out = [];

        if ($k < 0 || $n < 0) {
            return false;
        }

        if ($k === 0) {
            return [array_fill(0, $n, 0)];
        }

        if ($n === 0) {
            return [];
        }

        if ($n === 1) {
            return [[$k]];
        }

        foreach ($this->multiChoose($k, $n - 1) as $in) {
            array_unshift($in, 0);
            $out[] = $in;
        }

        foreach ($this->multiChoose($k - 1, $n) as $in) {
            $in[0]++;
            $out[] = $in;
        }

        return $out;
    }
}