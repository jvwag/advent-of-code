<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2017;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2017
 */
class Day23 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $instructions = explode("\n", trim($this->getInput()));

        $pos = 0;
        $registers = [];
        $mul_counter = 0;
        $count = \count($instructions);

        // for part1, loop until the 'rcv' opcode 'eats' the 'is_running' queue
        do {
            $pos += $this->execute($instructions[$pos], $registers, $mul_counter);
        } while ($pos < $count);


        /**
         * The second solution was solved by checking the reddit thread about this solution:
         * https://www.reddit.com/r/adventofcode/comments/7lms6p/2017_day_23_solutions/
         *
         * After concluding most people have rewritten the assembly to their native language
         * and the code was a prime finder between a given two numbers I decided to execute the
         * code to get to upper and lower boundary and to find the prime with my own code.
         */
        $pos = 0;
        $registers = ["a" => 1, "h" => 0];
        do {
            $pos += $this->execute($instructions[$pos], $registers);
        } while ($pos !== 8);

        // now count the number of primes using custom code
        $registers["h"] = $this->countPrimesBetween($registers["b"], $registers["c"], 17);

        // return answers
        return
            [
                $mul_counter,
                $registers["h"]
            ];
    }

    /**
     * @param string $instruction Instruction string
     * @param int[] $registers Registers array
     * @param int $mul_counter Counter for the number of multiplications
     * @return int New position offset
     */
    private function execute($instruction, &$registers, &$mul_counter = 0): int
    {
        // parse the instruction
        [$type, $reg] = $parts = explode(" ", $instruction);
        $value = $parts[2] ?? null;

        // if value or reg is a registry reference and it does not exist, create it
        if (!is_numeric($reg) && !isset($registers[$reg])) {
            $registers[$reg] = 0;
        }
        if ($value !== null && !is_numeric($value) && !isset($registers[$value])) {
            $registers[$value] = 0;
        }

        // @formatter:off
        // utility function to fetch the registry value, or use the numeric input cast to an integer
        $fetch = function ($x) use ($registers) { return is_numeric($x) ? (int)$x : $registers[$x]; };
        switch ($type) {
            // regular opcodes for arithmetic and jumps
            case "set": $registers[$reg] = $fetch($value); break;
            case "sub": $registers[$reg] -= $fetch($value); break;
            case "mul": $registers[$reg] *= $fetch($value); $mul_counter++; break;
            case "jnz": if ($fetch($reg) !== 0) { return $fetch($value); } break;
        }
        // @formatter:on

        // normal operations will add one to the program counter
        return 1;
    }

    /**
     * @param int $min Minimum number to test
     * @param int $max Maximum number to test
     * @param int $step Step to increment number
     * @return int Number of found primes
     */
    private function countPrimesBetween(int $min, int $max, int $step): int
    {
        $count = 0;
        // loop over all numbers from min to max increased by step
        for ($n = $min; $n <= $max; $n += $step) {
            // start by testing for a prime
            $sqrt = (int)floor(sqrt($n));
            for ($i = 2; $i <= $sqrt; $i++) {
                if ($n % $i === 0) {
                    // and count the number of primes
                    $count++;
                    break;
                }
            }
        }
        // return number of primes
        return $count;
    }

}