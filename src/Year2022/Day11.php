<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2022;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2022
 */
class Day11 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // parse the input as notes on the monkeys behaviour
        $notes = [];
        foreach (explode("\n\n", $this->getInput()) as $note) {
            // regex; so much better than string manipulation
            if (preg_match(
                "/^Monkey (\d+):\s+" .
                "Starting items: ([^\n]+)\s+" .
                "Operation: new = old ([*+]) (\d+|old)\s+" . // <-- this is a special case, 'old' will be int(0)
                "Test: divisible by (\d+)\s+" .
                "If true: throw to monkey (\d+)\s+" .
                "If false: throw to monkey (\d+)$/m", $note, $match)) {

                // store all notes in an array
                $notes[intval($match[1])] =
                    [
                        "items" => array_map("intval", explode(", ", $match[2])),
                        "worry_operator" => $match[3],
                        "worry_value" => intval($match[4]),
                        "divisible_by" => intval($match[5]),
                        "if_true" => intval($match[6]),
                        "if_false" => intval($match[7])
                    ];

            }
        }

        //
        return
            [
                $this->calculateMonkeyBusiness($notes, 20, 3),
                $this->calculateMonkeyBusiness($notes, 10000, 1)
            ];
    }

    public function calculateMonkeyBusiness(array $notes, int $rounds, int $div): int
    {
        // important for the second part, because the numbers are getting tiny bit huge
        // we should calculate the common division of all divisors and apply this
        // to our value to keep it manageable
        $highest_common_division = array_reduce($notes, function ($out, $a) {
            return $out * $a["divisible_by"];
        }, 1);

        // create an array to store the number of inspections per monkey
        $inspections = array_fill(0, count($notes), 0);

        // loop over all rounds
        for ($round = 0; $round < $rounds; $round++) {
            // loop over all notes
            for ($monkey = 0; $monkey < count($notes); $monkey++) {
                // loop over all items a monkey is carrying
                while ($notes[$monkey]["items"]) {
                    // get the first item
                    $item = array_shift($notes[$monkey]["items"]);
                    // add a counter to the inspection list
                    $inspections[$monkey]++;

                    // init worry level
                    $worry_level = 0;
                    // set the worry_level based on the worry_operator and worry_value
                    if ($notes[$monkey]["worry_operator"] === "*") {
                        // special case, the worry level is multiplied with itself, we have hijacked the value '0' to
                        // indicate this case
                        if ($notes[$monkey]["worry_value"] === 0) {
                            $worry_level = intval($item * $item);
                        } else {
                            $worry_level = intval($item * $notes[$monkey]["worry_value"]);
                        }
                    } elseif ($notes[$monkey]["worry_operator"] === "+") {
                        $worry_level = $item + $notes[$monkey]["worry_value"];
                    }

                    // in part 1 the div is 3, in part 2 we do not need to divide, but we will keep it here as a divide
                    // by one to keep the code for the two parts consistent
                    // also: to prevent big numbers in the calculation, mod the value by the highest_common_division
                    $worry_level = intval($worry_level / $div) % $highest_common_division;

                    // check if the worry_level is divisible by the given number in the monkey notes
                    // and move to one of the two given monkeys
                    if ($worry_level % $notes[$monkey]["divisible_by"] === 0) {
                        $notes[$notes[$monkey]["if_true"]]["items"][] = $worry_level;
                    } else {
                        $notes[$notes[$monkey]["if_false"]]["items"][] = $worry_level;
                    }
                }
            }
        }

        // sort the inspections array to get the monkeys with the highest inspections on top
        sort($inspections);
        // and return the product of the two highest values
        return array_pop($inspections) * array_pop($inspections);

    }
}