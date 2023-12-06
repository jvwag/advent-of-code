<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2023;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2023
 */
class Day5 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        $mappings = $seeds = $order = $outcomes = [];
        $current_map = null;
        foreach (explode("\n", trim($this->getInput())) as $line) {
            if (preg_match("/^seeds: (.*)$/", $line, $match)) {
                $seeds = explode(" ", $match[1]);
            } elseif (preg_match("/^\w+-to-(\w+) map:$/", $line, $match)) {
                $order[] = $current_map = $match[1] ;
            } elseif (preg_match("/^(\d+) (\d+) (\d+)$/", $line, $match)) {
                $mappings[$current_map][] = [intval($match[1]), intval($match[2]), intval($match[3])];
            }
        }

        foreach($seeds as $seed) {
            $outcomes[$seed] = $this->getNumber($seed, $order, $mappings);
        }

        // return answers
        return
            [
                min($outcomes),
                null
            ];
    }

    /**
     * @param mixed $seed
     * @param array $order
     * @param array $mappings
     * @return mixed
     */
    public function getNumber(mixed $seed, array $order, array $mappings): mixed
    {
        $current_number = $seed;
        foreach ($order as $category) {
            foreach ($mappings[$category] as [$dst_range, $src_range, $range_length]) {
                if ($current_number >= $src_range && $current_number < $src_range + $range_length) {
                    $current_number = $current_number - $src_range + $dst_range;
                    break;
                }
            }
        }
        return $current_number;
    }
}