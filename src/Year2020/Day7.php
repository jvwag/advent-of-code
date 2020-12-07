<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2020;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year202
 */
class Day7 extends Assignment
{
    const MY_BAG_COLOR = "shiny gold";

    /**
     * @return array
     */
    public function run(): array
    {
        $rule_list = [];
        $input = $this->getInput();
        // parse input
        foreach (explode("\n", $input) as $line) {
            // loop over all lines and parse the base and the contents
            if (preg_match("/^(.*) bags contain (.*)\.$/", trim($line), $match_lines)) {
                $rule_list[$match_lines[1]] = [];
                // loop over al contents and parse bags in color and count
                foreach (explode(",", $match_lines[2]) as $bags) {
                    if (preg_match("/^(\d+) (.*) bags?$/", trim($bags), $match_bags)) {
                        // $rule_list[base_color][contains_color] = contains_count
                        $rule_list[$match_lines[1]][$match_bags[2]] = intval($match_bags[1]);
                    }
                }
            }
        }

        // return answers
        return
            [
                // count the number of colored bags
                count(
                    // filter over all rules
                    array_filter(
                        $rule_list,
                        // and only match if a bag could contain a bag of my color
                        fn($c) => in_array(self::MY_BAG_COLOR, $this->recurse($rule_list, $c)[0]),
                        ARRAY_FILTER_USE_KEY)
                ),
                // return the sum of all bags in my shiny golden bag
                $this->recurse($rule_list, self::MY_BAG_COLOR)[1]
            ];
    }

    private function recurse(array $rule_list, string $current_bag_color): array
    {
        $sum_of_bags = 0;
        $unique_bag_colors = [];
        foreach ($rule_list[$current_bag_color] as $contained_bag_color => $contained_bag_count) {
            [$u, $s] = $this->recurse($rule_list, $contained_bag_color);
            $sum_of_bags += $contained_bag_count + ($contained_bag_count * $s);
            $unique_bag_colors = array_merge($unique_bag_colors, [$contained_bag_color], $u);
        }

        return [$unique_bag_colors, $sum_of_bags];
    }
}