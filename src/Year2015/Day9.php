<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2015;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2015
 */
class Day9 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $lines = \array_map("\\trim", \explode("\n", \trim($this->getInput())));

        // map all routes
        $map = [];
        foreach($lines as $line) {
            if (\preg_match("/^(.+) to (.+) = (.+)$/", $line, $match)) {
                $map[$match[1]][$match[2]] = $match[3];
                $map[$match[2]][$match[1]] = $match[3];
            }
        }

        // loop over all routes and calculate all permutations
        $sums = [];
        foreach(self::permutations(array_keys($map)) as $perm)
        {
            // now get the sum of the routes
            $c = \count($perm) - 1;
            $sum = 0;
            for($x = 0; $x < $c; $x++) {
                $sum += $map[$perm[$x]][$perm[$x + 1]];
            }

            // add to sum array to find min and max later
            $sums[] = $sum;
        }

        // return answers
        return
            [
                min($sums),
                max($sums)
            ];
    }

    /**
     * @param $items
     * @param array $perms
     *
     * @return array
     */
    public static function permutations($items, array $perms = []): array
    {
        if(!$items) {
            return [$perms];
        }

        $return = [];
        for($i = \count($items) - 1; $i >= 0; --$i)
        {
            $new_items = $items;
            $new_perms = $perms;
            array_unshift($new_perms, array_splice($new_items, $i, 1)[0]);
            /** @noinspection SlowArrayOperationsInLoopInspection */
            $return = array_merge($return, self::permutations($new_items, $new_perms));
        }

        return $return;
    }

}