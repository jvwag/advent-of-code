<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2018;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2018
 */
class Day19 extends Assignment
{
    /**
     * This kind of assignment requires some manual disassembling the given instruction:
     *
     * line 0 jumps to line 17
     * line 17 to 24 determines a large value in part one
     * line 27 to 35 will make this value even larger for part two
     * line 1 and two inits loop counters to a value of 1
     * line 3 to 16 is the main loop with a nested iteration
     *
     * main loop comes down to finding a sum of factors of the large number
     *
     * @return array
     */
    public function run(): array
    {
        // parse the input program, and instruction pointer register number
        [$program, $ip_reg] = $this->parse($this->getInput());

        // return answers
        // the sum_of_factors hack is disable on the first test (this could be enabled) but it is useful
        // to validate the proper working of the code
        return
            [
                // contents of register 0 after running the application with initial registers set to:
                $this->execute($program, [0, 0, 0, 0, 0, 0], $ip_reg)[0], // all registers set to 0
                $this->execute($program, [1, 0, 0, 0, 0, 0], $ip_reg, true)[0]  // r0 set to 1, others set to 0
            ];
    }


    /**
     * @param array $program Array with [string instruction, int a, int b, int c] elements
     * @param int[] $regs Array with registers
     * @param int $ip_reg The register used for the instruction pointer
     * @param bool $sum_factors_hack True is the sum of factors of the largest register needs to be calculated after 100 iterations
     * @return int[] Array with registers
     */
    public function execute(array $program, array $regs, int $ip_reg, bool $sum_factors_hack = false): array
    {
        // init vars
        $count = count($program);

        // get functions from Day16
        $functions = Day16::getFunctions();

        // loop over program
        $i = 0;
        do {
            // determine the current program instruction
            $instruction = $program[$regs[$ip_reg]];

            // execute the instruction
            $regs = $functions[array_shift($instruction)]($regs, ... $instruction);

            // but we only loop for about 100 instructions if the $sum_factors_hack is enabled
            // @todo this could be shorter, but need to determine a way of determining when the initiating of the large number is complete
            if ($sum_factors_hack && ++$i > 100) {
                // to find the target large number, get the largest value from the registers
                $max = max($regs);

                // now find the sum of factors of this large number, which is way faster
                $sum = 0;
                for ($f = 1; $f <= $max; $f++) {
                    // found a factor, add it to the sum
                    if (($max % $f) === 0) {
                        $sum += $f;
                    }
                }

                // create a new register array filled with zero's, since the calculated register will not
                $regs = array_fill(0, count($regs), 0);
                $regs[0] = $sum;
                break;
            }

            // add one to the program counter
            $regs[$ip_reg]++;

            // loop until the program pointer points outside of the program
        } while ($regs[$ip_reg] >= 0 && $regs[$ip_reg] < $count);

        // return the first register value
        return $regs;
    }

    /**
     * Parse
     *
     * @param string $input Assignment input
     * @return array Array with [$program, $ip_reg]:
     *               $program is an array with [string instruction, int a, int b, int c] elements,
     *               $ip_reg is an integer giving the register used for the instruction pointer
     */
    public function parse(string $input): array
    {
        // init vars
        $ip_reg = null;
        $program = [];

        // loop over each line
        foreach (explode("\n", $input) as $line) {
            if (preg_match("/^#ip (\d+)$/", $line, $match)) {
                // determine register for the program pointer
                $ip_reg = (int)$match[1];
            } elseif (preg_match("/^([a-z]{4}) (\d+) (\d+) (\d+)$/", $line, $match)) {
                // or, parse the program
                $program[] = [$match[1], (int)$match[2], (int)$match[3], (int)$match[4]];
            }
        }

        // return program and instruction pointer register number
        return [$program, $ip_reg];
    }
}