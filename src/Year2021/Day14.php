<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2021;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2021
 */
class Day14 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // init variables
        $polymer_value_at_step_10 = null;
        $pair_insertion_rules = [];

        // split the input in the template and a set of rules
        [$template, $rule_lines] = explode("\n\n", trim($this->getInput()));

        // parse each rule line
        foreach (explode("\n", trim($rule_lines)) as $line) {
            if (preg_match("/^(..) -> (.)$/", trim($line), $match)) {
                [, $pair, $insertion_letter] = $match;

                // split the two letters of the rule
                $pair_letters = str_split($pair);

                // create a rule pair containing the initial pair (AB) and the letter, and the two resulting pairs (AX, XB)
                $pair_insertion_rules[$pair] = [
                    $pair_letters[0] . $insertion_letter,
                    $insertion_letter . $pair_letters[1]
                ];
            }
        }

        // take the pairs from the template
        $pairs = array_count_values(
            [
                // a list of pairs starting from 0, every two characters
                ...str_split($template, 2),
                // and a list of pairs starting from 1, minus the last letter
                ...str_split(substr($template, 1, -1), 2)
            ]
        );

        // loop for 40 times
        for ($step = 1; $step <= 40; $step++) {
            // create a copy of the pair, so we don't read back our changes during the step
            $pairs_copy = $pairs;

            // loop over all rules
            foreach ($pair_insertion_rules as $pair => [$new_pair_1, $new_pair_2]) {
                if (isset($pairs_copy[$pair])) {
                    // determine the number of pairs
                    $count = $pairs_copy[$pair];

                    // reduce the number of pairs that we are processing
                    $pairs[$pair] -= $count;

                    // and increment the new pairs
                    $pairs[$new_pair_1] = ($pairs[$new_pair_1] ?? 0) + $count;
                    $pairs[$new_pair_2] = ($pairs[$new_pair_2] ?? 0) + $count;
                }
            }
            if ($step === 10) {
                $polymer_value_at_step_10 = $this->calculate_polymer($pairs);
            }
        }

        // return answers
        return
            [
                $polymer_value_at_step_10,
                $this->calculate_polymer($pairs)
            ];
    }

    private function calculate_polymer(array $pairs): int
    {
        $counts = [];
        // loop over all pairs
        foreach ($pairs as $pair => $count) {
            // take the first letter, and second letter from the pair
            [$first_letter, $second_letter] = str_split($pair);
            $counts[$first_letter] = ($counts[$first_letter] ?? 0) + $count;
            $counts[$second_letter] = ($counts[$second_letter] ?? 0) + $count;
        }

        // the answer is the maximum of a used letter, minus the minimum of a used letter
        // because we are counting letters in pairs, and a letter in a pair is used in two pairs
        // we divide it by two.

        // there is an edge case, probably with the first and last pairs, where a letter is not in two
        // pairs at the same time, that is why we round the division up
        return (int)ceil(max($counts) / 2) - (int)ceil(min($counts) / 2);
    }
}