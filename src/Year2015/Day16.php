<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2015;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2015
 */
class Day16 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // get input
        $lines = explode("\n", trim($this->getInput()));

        // init output
        $output1 = null;
        $output2 = null;

        // the clues we got
        $clues =
            [
                "children" => 3,
                "cats" => 7,
                "samoyeds" => 2,
                "pomeranians" => 3,
                "akitas" => 0,
                "vizslas" => 0,
                "goldfish" => 5,
                "trees" => 3,
                "cars" => 2,
                "perfumes" => 1,
            ];

        // compile sue list
        $data = [];
        foreach ($lines as $line) {
            if (preg_match("/Sue (\d+): (.*)/", trim($line), $match)) {
                foreach (explode(",", $match[2]) as $item) {
                    $boom = explode(":", $item);
                    $data[$match[1]][trim($boom[0])] = (int) trim($boom[1]);
                }
            }
        }

        // loop over all auntie sues
        foreach ($data as $sue_id => $values) {
            $match1 = 0;
            $match2 = 0;
            // see which values match the clues
            foreach ($values as $sue_key => $sue_value) {
                foreach ($clues as $clue_key => $clue_value) {
                    if ($sue_key === $clue_key) {
                        // for the second part we do some particular matching
                        if (($sue_key === "cats" || $sue_key === "trees") && $sue_value > $clue_value) {
                            $match2++;
                        // and more second part special matching
                        } elseif (($sue_key === "pomeranians" || $sue_key === "goldfish") && $sue_value < $clue_value) {
                            $match2++;
                        // and regular matching for both parts
                        } elseif ($sue_value === $clue_value) {
                            $match1++;
                            $match2++;
                        }
                    }
                }
            }

            // if we have the same amount of matches as we had values to match for, it must be this sue!
            if ($output1 === null && $match1 === count($values)) {
                $output1 = $sue_id;
            // same goes for the second part
            } elseif ($output2 === null && $match2 === count($values)) {
                $output2 = $sue_id;
            }
        }


        // return answers
        return
            [
                $output1,
                $output2,
            ];
    }
}