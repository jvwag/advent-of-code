<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2025;

use jvwag\AdventOfCode\Assignment;

class Day11 extends Assignment
{
    public function run(): array
    {
        // convert input
        $nodes = [];
        foreach (explode("\n", trim($this->getInput())) as $line) {
            [$id, $children] = explode(":", $line);
            $nodes[trim($id)] = explode(" ", trim($children));
        }

        // do a recursive search on the two assignments
        return
            [
                isset($nodes["you"]) ? $this->findAllPaths($nodes,"you", "out", 1) : null,
                isset($nodes["svr"]) ? $this->findAllPaths($nodes,"svr", "out", 2) : null
            ];
    }

    public function findAllPaths($nodes, $start, $end, $part, $found_fft = false, $found_dac = false, &$cache = []): int
    {
        // caching to handle repetitive function calls
        $cache_key = "$start|$end|$part|$found_fft|$found_dac";
        if (isset($cache[$cache_key])) {
            return $cache[$cache_key];
        }

        // for part2: if we matched 'fft' or 'dac' we will raise those flags so we know if we need to add them to the counter
        if ($start === "fft") {
            $found_fft = true;
        } elseif ($start === "dac") {
            $found_dac = true;
        }

        if ($start === $end) {
            // if we found the end:
            // doing part 1: this is a valid path and return 1
            // doing part 2? only return 1 if we have passed 'fft' and 'dac'
            if ($part === 1 || $part === 2 && $found_fft && $found_dac) {
                return 1;
            }
            // or return zero
            return 0;
        }

        // loop over all possible neighbours
        $sum = 0;
        foreach ($nodes[$start] as $neighbour) {
            // sum all the possible paths from here
            $sum += $this->findAllPaths($nodes, $neighbour, $end, $part, $found_fft, $found_dac, $cache);
        }

        // create a cache
        $cache[$cache_key] = $sum;
        return $sum;
    }
}