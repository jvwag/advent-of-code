<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2020;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2020
 */
class Day6 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        $c = $group_size[0] = 0;
        $answers_per_group = [];
        foreach (explode("\n", trim($this->getInput())) as $line) {
            // if we have a empty line, we start a new group
            if ($line === "") {
                $answers_per_group[++$c] = [];
                $group_size[$c] = 0;
            } else {
                // add counter for the number of people in a group
                $group_size[$c]++;
                // loop over the answers of a specific person
                foreach (count_chars($line) as $k => $v) {
                    // only use the counted arrays with more than one value in it
                    if ($v > 0) {
                        // initialize a entry if it does not exist
                        if (!isset($answers_per_group[$c][$k])) {
                            $answers_per_group[$c][$k] = 0;
                        }
                        // add the number of answers given by a person to the group list
                        $answers_per_group[$c][$k] += $v;
                    }
                }
            }
        }

        // return answers
        return
            [
                // sum in each group
                array_reduce($answers_per_group,
                    // the number of unique questions were answered
                    fn($counter, $group) => $counter + count($group)
                ),
                // sum in each group
                array_reduce(
                    array_keys($answers_per_group),
                    // the number of answers (count)
                    fn($counter, $group_id) => $counter + count(
                        // where the number of answers was yes, is the same as the group size
                            array_filter($answers_per_group[$group_id],
                                fn($b) => $b === $group_size[$group_id]
                            )
                        )
                )
            ];
    }
}