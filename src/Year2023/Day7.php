<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2023;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2023
 */
class Day7 extends Assignment
{
    private const ORDER = ["0", "2", "3", "4", "5", "6", "7", "8", "9", "T", "J", "Q", "K", "A"];
    private const JOKER_ASCII = 74;
    private const JOKER_CHAR = "J";
    private const JOKER_ALT_SCORING = "0";

    /**
     * @return array
     */
    public function run(): array
    {
        // init vars
        $list_of_bids = $list_of_hands = $list_of_hands_with_jokers = [];
        $total_winnings = $total_winning_with_jokers = 0;

        // loop over all lines
        foreach (explode("\n", trim($this->getInput())) as $line) {
            // extract each hand, and put each bids in an array for later processing
            [$hand, $list_of_bids[]] = explode(" ", $line);

            // convert a hand ('32T3K') to a sortable string ('22192C'), starting with the hand type (1-7) and five
            // chars for the strength of the card in hexadecimal (0-D, E and F are not used)
            $list_of_hands[] = $this->convertHandToSortableString($hand);
            $list_of_hands_with_jokers[] = $this->convertHandToSortableString($hand, true);
        }

        // copy the list of bids and sort the list of bids the same order as the list of hands
        $bids = $list_of_bids;
        array_multisort($list_of_hands, $bids);
        // walk over all bids, now sorted by rank and calculate all winnings
        array_walk($bids, function ($bid, $rank) use (&$total_winnings) {
            $total_winnings += $bid * ($rank + 1);
        });

        // repeat this for the list of hands where we use jokers
        $bids = $list_of_bids;
        array_multisort($list_of_hands_with_jokers, $bids);
        array_walk($bids, function ($bid, $rank) use (&$total_winning_with_jokers) {
            $total_winning_with_jokers += $bid * ($rank + 1);
        });

        // return answers
        return
            [
                $total_winnings,
                $total_winning_with_jokers
            ];
    }

    public function convertHandToSortableString(string $hand, $handle_jokers = false): string
    {
        // count each type of card in hand
        $count_of_card_types = count_chars($hand, 1);

        // if we process part to, do some special stuff to handle the jokers
        if ($handle_jokers && isset($count_of_card_types[self::JOKER_ASCII])) {
            // save how many jokers we have got in this hand
            $j_count = $count_of_card_types[self::JOKER_ASCII];
            // and unset the jokers from the card count
            unset($count_of_card_types[self::JOKER_ASCII]);
            // sort the list of card types, brining the most common card to index 0
            rsort($count_of_card_types);
            // in the edge case we have a hand with 5 jokers, there is no index 0, so we init this
            $count_of_card_types[0] ??= 0;
            // add the number of jokers to any card type with the highest number of cards
            // it does not mather which card type because a joker will have the lowest weight
            $count_of_card_types[0] += $j_count;

            // to make sure we calculate the weight properly replace tje 'J' with a '0' indicating
            // the joker has the lowest weight
            $hand = str_replace(self::JOKER_CHAR, self::JOKER_ALT_SCORING, $hand);
        }

        // count the number of card groups, and fill some missing values: this way we don't have to check for key existence
        $count_of_card_groups = array_count_values($count_of_card_types) + array_fill(1, 5, 0);
        // determine the first character of the output, based on the type of card combinations will find
        if ($count_of_card_groups[5] === 1) {
            $output = 7; // five of a kind
        } elseif ($count_of_card_groups[4] === 1) {
            $output = 6; // four of a kind
        } elseif ($count_of_card_groups[3] === 1 && $count_of_card_groups[2] === 1) {
            $output = 5; // full house
        } elseif ($count_of_card_groups[3] === 1) {
            $output = 4; // three of a kind
        } elseif ($count_of_card_groups[2] === 2) {
            $output = 3; // two pair
        } elseif ($count_of_card_groups[2] === 1) {
            $output = 2; // one pair
        } else {
            $output = 1; // high card
        }

        // now take each card and replace the card character with a weighted value,
        // because we have more than 10 type of cards we use hexadecimal ('0'(=Joker) => 0x0, '2' => 0x1, 'K' => 0xD)
        foreach (str_split($hand) as $card) {
            $output .= dechex(array_search($card, self::ORDER));
        }

        // return the string, ready for sorting
        return $output;
    }
}