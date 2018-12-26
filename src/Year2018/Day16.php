<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2018;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2018
 */
class Day16 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // split input into two parts
        [$input_part1, $input_part2] = explode("\n\n\n", $this->getInput());

        // get defined functions
        $functions = self::getFunctions();

        // parse all examples from part one and create a list with possible opcode combinations
        $possible_opcodes = [];
        $examples_with_more_than_two_possible_opcodes = 0;
        foreach (explode("\n\n", trim($input_part1)) as $part) {
            // match an example
            if (preg_match("/Before:\s+\[(\d+),\s+(\d+),\s+(\d+),\s+(\d+)\]\n(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\nAfter:\s+\[(\d+),\s+(\d+),\s+(\d+),\s+(\d+)\]/", $part, $match)) {
                // extract all registers (before and after) and the program line
                [, $input_regs[0], $input_regs[1], $input_regs[2], $input_regs[3],
                    $opcode_number, $a, $b, $c,
                    $expected_regs[0], $expected_regs[1], $expected_regs[2], $expected_regs[3]] = array_map("intval", $match);

                // loop over all possible opcode functions to see if they match with the expected solution
                $possible_opcode_count = 0;
                foreach ($functions as $opcode_name => $function) {
                    // execute opcode function
                    $output_regs = $function($input_regs, $a, $b, $c);

                    // if we found a possible solution to a opcode
                    if ($output_regs === $expected_regs) {
                        // register a specific opcode
                        $possible_opcodes[$opcode_name][$opcode_number] = $opcode_number;
                        // count the number of possible opcodes for this example
                        $possible_opcode_count++;
                    }
                }

                // for the part one solution we need the number of examples with more than two possible opcodes
                if ($possible_opcode_count > 2) {
                    $examples_with_more_than_two_possible_opcodes++;
                }
            }
        }

        // create a final opcode list by looping over all possible opcodes
        $opcode_list = [];
        while ($possible_opcodes) {
            foreach ($possible_opcodes as $opcode_name => $opcode_numbers) {
                // if a opcode has only one possible number its a determined opcode
                if (count($opcode_numbers) === 1) {
                    // the found opcode, and add it to the list
                    $found_opcode = reset($opcode_numbers);
                    $opcode_list[$found_opcode] = $opcode_name;

                    // now remove the opcode from the possible opcodes list
                    $possible_opcodes = array_filter(
                        array_map(function ($nrs) use ($found_opcode) {
                            return array_filter($nrs, function ($element) use ($found_opcode) {
                                return $element !== $found_opcode;
                            });
                        }, $possible_opcodes));
                }
            }
        }

        // loop over the input from part two to run the code
        $regs = [0, 0, 0, 0];
        foreach (explode("\n", trim($input_part2)) as $p) {
            // get input line and convert to integers
            [$opcode_number, $a, $b, $c] = array_map("intval", explode(" ", trim($p)));
            // call the function using the opcode lookup table created earlier
            $regs = $functions[$opcode_list[$opcode_number]]($regs, $a, $b, $c);
        }

        // return answers
        return
            [
                $examples_with_more_than_two_possible_opcodes,
                $regs[0], // first register from running the code
            ];
    }

    public static function getFunctions(): array {
        // @formatter:off
        return [
            "addr" => function ($regs, $a, $b, $c) { $regs[$c] = $regs[$a] + $regs[$b]; return $regs; },
            "addi" => function ($regs, $a, $b, $c) { $regs[$c] = $regs[$a] + $b; return $regs; },
            "mulr" => function ($regs, $a, $b, $c) { $regs[$c] = $regs[$a] * $regs[$b]; return $regs; },
            "muli" => function ($regs, $a, $b, $c) { $regs[$c] = $regs[$a] * $b; return $regs; },
            "banr" => function ($regs, $a, $b, $c) { $regs[$c] = $regs[$a] & $regs[$b]; return $regs; },
            "bani" => function ($regs, $a, $b, $c) { $regs[$c] = $regs[$a] & $b; return $regs; },
            "borr" => function ($regs, $a, $b, $c) { $regs[$c] = $regs[$a] | $regs[$b]; return $regs; },
            "bori" => function ($regs, $a, $b, $c) { $regs[$c] = $regs[$a] | $b; return $regs; },
            "setr" => function ($regs, $a, $b, $c) { $regs[$c] = $regs[$a]; return $regs; },
            "seti" => function ($regs, $a, $b, $c) { $regs[$c] = $a; return $regs; },
            "gtir" => function ($regs, $a, $b, $c) { $regs[$c] = $a > $regs[$b] ? 1 : 0; return $regs; },
            "gtri" => function ($regs, $a, $b, $c) { $regs[$c] = $regs[$a] > $b ? 1 : 0; return $regs; },
            "gtrr" => function ($regs, $a, $b, $c) { $regs[$c] = $regs[$a] > $regs[$b] ? 1 : 0; return $regs; },
            "eqir" => function ($regs, $a, $b, $c) { $regs[$c] = $a === $regs[$b] ? 1 : 0; return $regs; },
            "eqri" => function ($regs, $a, $b, $c) { $regs[$c] = $regs[$a] === $b ? 1 : 0; return $regs; },
            "eqrr" => function ($regs, $a, $b, $c) { $regs[$c] = $regs[$a] === $regs[$b] ? 1 : 0; return $regs; },
        ];
        // @formatter:on
    }
}