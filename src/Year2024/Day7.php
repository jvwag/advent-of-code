<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2024;

use jvwag\AdventOfCode\Assignment;

class Day7 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        $total_calibration_result = $total_calibration_result_with_extra_operator = 0;

        // loop over all calibrations
        foreach (explode("\n", trim($this->getInput())) as $line) {
            // extract the values
            $equation_values = explode(" ", trim($line));
            // the first item is the test value, and we need to remove the colon
            $test_value = intval(trim(array_shift($equation_values), ":"));
            // convert all values of the equation to integers
            $equation_values = array_map("intval", $equation_values);

            // process the equations: if the equation can be made valid, it will return the test value, else 0
            $total_calibration_result += $this->processEquation($equation_values, $test_value);
            $total_calibration_result_with_extra_operator += $this->processEquation($equation_values, $test_value, true);
        }

        // return answers
        return
            [
                $total_calibration_result,
                $total_calibration_result_with_extra_operator
            ];
    }

    function processEquation(array $equation, int $test_value, $part2 = false): int
    {
        // we will use a queue to process all permutations of the equation
        $queue[] = $equation;

        // while there are still equations in the queue
        while ($queue) {
            foreach ($queue as $i => $equation) {
                // if the equation is only one value long
                if (count($equation) === 1) {
                    // and it is equal to the test value
                    if ($test_value === $equation[0]) {
                        // return the test value
                        return $test_value;
                    }
                } else {
                    // take the first two items from the equation
                    $a = array_shift($equation);
                    $b = array_shift($equation);

                    // and combine the values using different operators,
                    // and putting them with the remaining equation back on the queue
                    $queue[] = array_merge([$a * $b], $equation);
                    $queue[] = array_merge([$a + $b], $equation);

                    // part2 has an extra operator to check
                    if ($part2) {
                        $queue[] = array_merge([intval($a . $b)], $equation);
                    }
                }
                // unset processed equation (or answer that is not equal to the test value)
                unset($queue[$i]);
            }
        }
        // if the queue is empty and the solved equations did not match the test value, return 0
        return 0;
    }
}