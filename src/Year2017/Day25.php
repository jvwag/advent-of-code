<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2017;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2017
 */
class Day25 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // get input
        $input = $this->getInput();

        preg_match("/Begin in state (.)./", $input, $match);
        /** @todo remove noinspection and $tmp after fix for https://youtrack.jetbrains.com/issue/WI-34517 */
        /** @noinspection PhpUnusedLocalVariableInspection */
        [$x, $state] = $match;

        preg_match("/Perform a diagnostic checksum after (\d+) steps./", $input, $match);
        /** @todo remove noinspection and $tmp after fix for https://youtrack.jetbrains.com/issue/WI-34517 */
        /** @noinspection PhpUnusedLocalVariableInspection */
        [$tmp, $iterations] = $match;

        // init vars
        $memory = [0 => 0];
        $pos = 0;
        $rules = [];
        $regex_block =
            "\s+If the current value is (\d):" .
            "\s+- Write the value (\d+)\." .
            "\s+- Move one slot to the (left|right)\." .
            "\s+- Continue with state (.)\.";

        // match all state rules
        preg_match_all("/In state (.):" . $regex_block . $regex_block . "/", $input, $match);

        // loop over all states
        $c_states = \count($match[0]);
        for ($x = 0; $x < $c_states; $x++) {
            // we have two sets, and the second offset is 4
            foreach ([0, 4] as $y) {
                // create a rule bases on the input
                $rules[$match[1][$x]][$match[2 + $y][$x]] = ["set" => $match[3 + $y][$x], "step" => $match[4 + $y][$x] === "left" ? -1 : 1, "new_state" => $match[5 + $y][$x]];
            }
        }

        // loop all iterations
        for ($i = 0; $i < $iterations; $i++) {
            // create memory if needed
            if (!isset($memory[$pos])) {
                $memory[$pos] = 0;
            }

            // find the rule corresponding with the current state and memory value
            $rule = $rules[$state][$memory[$pos]];

            // apply the rule
            $memory[$pos] = $rule["set"];
            $pos += $rule["step"];
            $state = $rule["new_state"];
        }

        // return answers
        return
            [
                \array_sum($memory),
                null
            ];
    }
}