<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2024;

use jvwag\AdventOfCode\Assignment;

class Day5 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // init vars
        $rules = [];
        $sum_of_middle_value_in_valid_page_lists = $sum_of_middle_value_in_reordered_page_lists = 0;

        // split the input in two parts: the rules and the page lists
        $input_parts = explode("\n\n", trim($this->getInput()));

        // loop over the rules to make a rule array
        foreach (explode("\n", trim($input_parts[0])) as $line) {
            [$key, $value] = array_map("intval", explode("|", trim($line)));
            $rules[$value][] = $key;
        }

        // loop over lines that have the page lists
        foreach (explode("\n", trim($input_parts[1])) as $line) {
            $valid = true;
            // parse a page list and loop over every page
            $page_list = array_map("intval", explode(",", trim($line)));
            foreach ($page_list as $pos => $page) {
                // if there is a rule for the page
                foreach ($rules[$page] ?? [] as $rule_page) {
                    // look if it is valid by checking the rest of the pages: if it contains a page
                    // in the rule the page list is not valid
                    if (in_array($rule_page, array_slice($page_list, $pos + 1), true)) {
                        $valid = false;
                        break 2; // stop processing this page list and go to the next
                    }

                }
            }
            // function to get the middle value of an array
            $array_middle = function(array $page_list) { return $page_list[floor(count($page_list) / 2)]; };

            // so, we found a valid page list
            if ($valid) {
                // find the sum value in the middle of the page list and add it to the sum
                $sum_of_middle_value_in_valid_page_lists += $array_middle($page_list);
            } else {
                // sort the page list
                usort($page_list, function($a, $b) use ($rules) {
                    // if the items we compare are in the rules list, order to the left, else to the right
                    return in_array($a, $rules[$b] ?? []) ? -1 : 1;
                });
                // find the sum value in the middle of the page list and add it to the sum
                $sum_of_middle_value_in_reordered_page_lists += $array_middle($page_list);
            }
        }

        // return answers
        return
            [
                $sum_of_middle_value_in_valid_page_lists,
                $sum_of_middle_value_in_reordered_page_lists
            ];
    }
}