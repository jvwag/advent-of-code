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
        // init vars
        $mappings = $seeds = $ranges = [];
        $current_map = null;

        // loop over the input
        foreach (explode("\n", trim($this->getInput())) as $line) {
            // match the seeds line, and create a list of seeds, and a list of ranges for part 2
            if (preg_match("/^seeds: (.*)$/", $line, $match)) {
                $seeds = array_map("intval", explode(" ", $match[1]));
                $ranges = array_chunk($seeds, 2);
            } elseif (preg_match("/^\w+-to-(\w+) map:$/", $line, $match)) {
                // match the name of each new map
                $current_map = $match[1];
            } elseif (preg_match("/^(\d+) (\d+) (\d+)$/", $line, $match)) {
                // write mappings to a big array
                $mappings[$current_map][] = [intval($match[1]), intval($match[2]), intval($match[3])];
            }
        }

        // for part one, iterate over each seed
        foreach ($seeds as &$seed) {
            // iterate over each category
            foreach ($mappings as $mapping) {
                // and each mapping in a category
                foreach ($mapping as [$dst_range, $src_range, $range_length]) {
                    // if the seed is in range of the mapping
                    if ($seed >= $src_range && $seed < $src_range + $range_length) {
                        // adjust the seed using the mapping
                        $seed = $seed - $src_range + $dst_range;
                        break;
                    }
                }
            }
        }

        // for part two we also iterate over all mapping categories
        foreach ($mappings as $mapping) {
            // the list of ranges will be put in a queue, and cleared to after processing the queue we have a new set of ranges
            $queue = $ranges;
            $ranges = [];
            // loop over all ranges
            while ($queue) {
                // get a range from the queue, also determine the end of the range
                [$range_start, $range_length] = array_shift($queue);
                $range_end = $range_start + $range_length;

                // count the number of mappings, if we skipped all mappings we should fall through the mapping later
                $number_of_mappings = count($mapping);
                // loop over all mappings in the category, also calculate some derivatives of the map that we need later
                foreach ($mapping as [$map_new_start, $map_start, $map_length]) {
                    $map_offset = $map_new_start - $map_start;
                    $map_end = $map_start + $map_length;

                    // if the range does not fall in the mapping, skip this mapping
                    if ($range_end <= $map_start || $map_end <= $range_start) {
                        $number_of_mappings--;
                        continue;
                    } elseif ($range_start < $map_start) { // if the range starts before the mapping
                        // slice a piece before the current map to process later
                        $queue[] = [$range_start, $map_start - $range_start];
                    } elseif ($map_end < $range_end) { // or if the range extends the mapping
                        // slice a piece after the current map to process later
                        $queue[] = [$map_end, $range_end - $map_end];
                    }

                    // the new range following
                    $ranges[] = [
                        max($map_start, $range_start) + $map_offset, // new range start, plus the map offset
                        min($map_end, $range_end) - max($map_start, $range_start) // length
                    ];
                }

                // if we did not create new ranges using the mappings, we should fallthrough our current mapping
                if (!$number_of_mappings) {
                    $ranges[] = [$range_start, $range_length];
                }
            }
        }

        // return answers
        return
            [
                min($seeds), // minimum value of the processed seeds
                array_reduce($ranges, function ($carry, $v) { // minimum value of the range_start (first item of the range array)
                    return isset($carry) ? min($carry, $v[0]) : $v[0];
                })
            ];
    }
}