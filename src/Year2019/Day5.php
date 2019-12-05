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

    private const LENGTH = [
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
            $instruction = $program[$pointer] % 100;

            $param_pointer = [];
            // determine parameters, and their absolute or relative position
            for ($i = 1; $i < self::LENGTH[$instruction]; $i++) {
                switch ((int)floor($program[$pointer] / (10 ** (1 + $i))) % 10) {
                    case self::M_POS;
                        $param_pointer[$i] = $program[$pointer + $i];
                        break;
                    case self::M_IMM;
                        $param_pointer[$i] = $pointer + $i;
                        break;
                    default:
                        throw new RuntimeException("Invalid mode for parameter " . $i . " in position " . $pointer);
                }
            }

            switch ($instruction) {
                case self::ADD:
                    $program[$param_pointer[3]] = $program[$param_pointer[1]] + $program[$param_pointer[2]];
                    break;
                case self::MULTIPLY:
                    $program[$param_pointer[3]] = $program[$param_pointer[1]] * $program[$param_pointer[2]];
                    break;
                case self::INPUT:
                    $program[$param_pointer[1]] = $input;
                    break;
                case self::JUMP_TRUE:
                    if ($program[$param_pointer[1]] !== 0) {
                        $pointer = $program[$param_pointer[2]];
                        // after a jump we continue directly to processing the new instruction and not to increment
                        // the program counter.
                        continue 2;
                    }
                    break;
                case self::JUMP_FALSE:
                    if ($program[$param_pointer[1]] === 0) {
                        $pointer = $program[$param_pointer[2]];
                        // same as previous jump
                        continue 2;
                    }
                    break;
                case self::IF_LESS:
                    $program[$param_pointer[3]] = $program[$param_pointer[1]] < $program[$param_pointer[2]] ? 1 : 0;
                    break;
                case self::IF_EQUAL:
                    $program[$param_pointer[3]] = $program[$param_pointer[1]] === $program[$param_pointer[2]] ? 1 : 0;
                    break;
                case self::OUTPUT:
                    $output = $program[$param_pointer[1]];
                    break;
                case self::END:
                    break 2;
                default:
                    throw new RuntimeException("Invalid instruction " . $instruction . " on pos " . $pointer);
            }

            // increment steps bases on the type of instruction
            $pointer += self::LENGTH[$instruction];
        }

        return $output;
    }
}