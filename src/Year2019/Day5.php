<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2019;

use jvwag\AdventOfCode\Assignment;
use RuntimeException;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2019
 */
class Day5 extends Assignment
{
    private const ADD = 1;
    private const MULTIPLY = 2;
    private const INPUT = 3;
    private const OUTPUT = 4;
    private const JUMP_TRUE = 5;
    private const JUMP_FALSE = 6;
    private const IF_LESS = 7;
    private const IF_EQUAL = 8;
    private const END = 99;

    private const M_POS = 0;
    private const M_IMM = 1;

    private const STEPS = [
        self::ADD => 4, self::MULTIPLY => 4, self::INPUT => 2, self::OUTPUT => 2,
        self::JUMP_TRUE => 3, self::JUMP_FALSE => 3, self::IF_LESS => 4, self::IF_EQUAL => 4,
    ];

    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $program = array_map("intval", explode(",", trim($this->getInput())));

        // return answers
        return
            [
                $output1 = $this->process($program, 1),
                $output2 = $this->process($program, 5),
            ];
    }

    public function process(array $program, $input): int
    {
        $pointer = 0;
        $output = 0;

        // loop over the program
        while (true) {
            // TODO: refactor this code to: check for opcode first, and then parse parameters if needed

            // determine parameter 1
            switch ((int)floor($program[$pointer] / 100) % 10) {
                case self::M_POS;
                    $param1 = $program[$program[$pointer + 1]];
                    break;
                case self::M_IMM;
                    $param1 = $program[$pointer + 1];
                    break;
                default:
                    throw new RuntimeException("Invalid mode for parameter 1");
            }

            // determine parameter 2
            switch ((int)floor($program[$pointer] / 1000) % 10) {
                case self::M_POS;
                    $param2 = $program[$program[$pointer + 2]];
                    break;
                case self::M_IMM;
                    $param2 = $program[$pointer + 2];
                    break;
                default:
                    throw new RuntimeException("Invalid mode for parameter 2");
            }

            // determine instruction
            $instruction = $program[$pointer] % 100;
            switch ($instruction) {
                case self::ADD:
                    $program[$program[$pointer + 3]] = $param1 + $param2;
                    break;
                case self::MULTIPLY:
                    $program[$program[$pointer + 3]] = $param1 * $param2;
                    break;
                case self::INPUT:
                    $program[$program[$pointer + 1]] = $input;
                    break;
                case self::JUMP_TRUE:
                    if ($param1 !== 0) {
                        $pointer = $param2;
                        // after a jump we continue directly to processing the new instruction and not to increment
                        // the program counter.
                        continue 2;
                    }
                    break;
                case self::JUMP_FALSE:
                    if ($param1 === 0) {
                        $pointer = $param2;
                        // same as previous jump
                        continue 2;
                    }
                    break;
                case self::IF_LESS:
                    $program[$program[$pointer + 3]] = $param1 < $param2 ? 1 : 0;
                    break;
                case self::IF_EQUAL:
                    $program[$program[$pointer + 3]] = $param1 === $param2 ? 1 : 0;
                    break;
                case self::OUTPUT:
                    $output = $param1;
                    break;

                case self::END:
                    break 2;
                default:
                    throw new RuntimeException("Invalid instruction " . $instruction . " on pos " . $pointer);
            }

            // increment steps bases on the type of instruction
            $pointer += self::STEPS[$instruction];
        }

        return $output;
    }
}