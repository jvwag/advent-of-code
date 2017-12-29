<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2015;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2015
 */
class Day5 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $words = \array_map("\\trim", \explode("\n", \trim($this->getInput())));

        // init output
        $nice1 = 0;
        $nice2 = 0;

        // loop over all words
        foreach ($words as $word) {

            // count characters
            $count_chars = [];
            foreach (\count_chars($word) as $k => $v) {
                $count_chars[\chr($k)] = $v;
            }

            // determine there are at least three vowels
            $at_least_three_vowels = ($count_chars["a"] +
                    $count_chars["e"] +
                    $count_chars["i"] +
                    $count_chars["o"] +
                    $count_chars["u"]) >= 3;

            // determine letter hopping and two consecutive letters
            $letter_hop = false;
            $two_consecutive_letters = false;
            foreach ($count_chars as $letter => $c) {
                if ($c > 1) {
                    if ($two_consecutive_letters === false && \strpos($word, \str_repeat($letter, 2)) !== false) {
                        $two_consecutive_letters = true;
                    }

                    if ($letter_hop === false && \preg_match("|" . $letter . "." . $letter . "|", $word)) {
                        $letter_hop = true;
                    }
                }
            }

            // determine bad combo's
            $no_bad_combos = true;
            foreach (["ab", "cd", "pq", "xy"] as $bad_word) {
                if (\strpos($word, $bad_word) !== false) {
                    $no_bad_combos = false;
                }
            }

            // determine repeating letters (like: xyx)
            $i = 0;
            $max_index = \strlen($word) - 2;
            $two_repeat = false;
            do {
                $char_combo = \substr($word, $i, 2);
                $char_combo_pos = \strpos($word, $char_combo);
                if ($char_combo_pos !== false && ($char_combo_pos > $i + 1 || $char_combo_pos < $i - 1)) {
                    $two_repeat = true;
                    break;
                }
            } while ($i++ < $max_index);

            // count answer 1
            if ($at_least_three_vowels && $two_consecutive_letters && $no_bad_combos) {
                $nice1++;
            }

            // count answer 2
            if ($two_repeat && $letter_hop) {
                $nice2++;
            }
        }

        // return answers
        return
            [
                $nice1,
                $nice2,
            ];
    }
}