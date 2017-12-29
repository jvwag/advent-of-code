<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2015;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2015
 */
class Day13 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        ini_set('memory_limit','512M');

        // convert input
        $lines = explode("\n", $this->getInput());

        // convert rules to data
        $data = [];
        foreach($lines as $line) {
            if (preg_match("/^(.+) would (gain|lose) (\d+) happiness units by sitting next to (.+).$/", $line, $match)) {
                $data[$match[1]][$match[4]] = $match[3] * ($match[2] === "gain" ? 1 : -1);
            }
        }

        // calculate happiness
        $output1 = $this->happiness($data);

        // add me to the list
        foreach(array_keys($data) as $person)
        {
            $data["me"][$person] = 0;
            $data[$person]["me"] = 0;
        }

        // calculate new happiness
        $output2 = $this->happiness($data);

        // return answers
        return
            [
                $output1,
                $output2,
            ];
    }

    /**
     * @param array $data
     *
     * @return int
     */
    public function happiness(array $data): int
    {
        // init vars
        $sums = [];
        $c = \count(\array_keys($data));
        // go over all possible permutations
        foreach (Day9::permutations(array_keys($data)) as $person) {
            $sum = 0;
            // loop over the round table to see how it will fit
            for ($i = 0; $i < $c; $i++) {
                $sum += $data[$person[$i]][$person[($i + 1) % $c]] + $data[$person[($i + 1) % $c]][$person[$i]];
            }

            // sum the sums
            $sums[] = $sum;
        }

        // get the most happiness!
        return max($sums);
    }
}