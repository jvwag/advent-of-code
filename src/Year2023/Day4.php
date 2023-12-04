<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2023;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2023
 */
class Day4 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // init vars
        $sum_of_points = $sum_of_cards = $card_number = 0;

        // parse the number of lines, and create an array of cards set to 1
        $list_of_cards = explode("\n", $this->getInput());
        $card_counter = array_fill(1, count($list_of_cards) - 1, 1);

        // loop over all cards
        foreach ($list_of_cards as $card) {
            $card_number++;
            if (preg_match("/^Card\s+\d+: ([^|]+) \| (.*)$/", $card, $match)) {
                // parse the list of winning numbers, and my numbers
                $winning_numbers = array_map("intval", preg_split("/\s+/", trim($match[1])));
                $my_numbers = array_map("intval", preg_split("/\s+/", trim($match[2])));

                // count the intersecting numbers of my numbers and the winning numbers
                $matching_number_count = count(array_intersect($my_numbers, $winning_numbers));

                // calculate the number of points (0, 1, or 2 to the power of the matching number count)
                $points = $matching_number_count > 1 ? 2 ** ($matching_number_count - 1) : $matching_number_count;

                // loop over the number of matching numbers
                for ($i = 1; $i <= $matching_number_count; $i++) {
                    // only if it's a valid card number
                    if (isset($card_counter[$card_number + $i]))
                        // add the number of current cards to the card counter for the following cards
                        $card_counter[$card_number + $i] += $card_counter[$card_number];
                }

                // add the sums of points and processed card numbers
                $sum_of_points += $points;
                $sum_of_cards += $card_counter[$card_number];
            }
        }

        // return answers
        return
            [
                $sum_of_points,
                $sum_of_cards
            ];
    }
}