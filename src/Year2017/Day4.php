<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2017;

use jvwag\AdventOfCode\Assignment;
use jvwag\AdventOfCode\Year2015\Day9;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2017
 */
class Day4 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // get input
        $lines = explode("\n", trim($this->getInput()));

        // the output starts with the number of passwords
        $output1 = $output2 = count($lines);

        // we loop over all passwords
        foreach ($lines as $line) {
            // extract the words
            $words = explode(" ", $line);

            // loop over each word
            $c = count($words);
            for ($i = 0; $i < $c; $i++) {
                // and the following words
                for ($l = $i + 1; $l < $c; $l++) {
                    // if equal, test1 and test2 fail
                    if ($words[$i] === $words[$l]) {
                        $output1--;
                        $output2--;
                        break 2; // make sure we don't test ay more
                    }
                    // if the words are equal in length
                    if (strlen($words[$i]) === strlen($words[$l])) {
                        // test if any permutation of the word matches
                        foreach (Day9::permutations(str_split($words[$l])) as $word_arr) {
                            // if so, adjust the counter for test2
                            if ($words[$i] === implode("", $word_arr)) {
                                $output2--;
                                break 3; // and stop testing this pass phrase
                            }
                        }
                    }
                }
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