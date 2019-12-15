<?php

namespace jvwag\AdventOfCode\Year2019;

use RuntimeException;

class IntcodeComputer
{
    private const ADD = 1;
    private const MULTIPLY = 2;
    private const INPUT = 3;
    private const OUTPUT = 4;
    private const JUMP_TRUE = 5;
    private const JUMP_FALSE = 6;
    private const IF_LESS = 7;
    private const IF_EQUAL = 8;
    private const REL_BASE = 9;
    private const END = 99;

    private const M_POS = 0;
    private const M_IMM = 1;
    private const M_REL = 2;

    private const LENGTH = [
        self::ADD => 4, self::MULTIPLY => 4, self::INPUT => 2, self::OUTPUT => 2,
        self::JUMP_TRUE => 3, self::JUMP_FALSE => 3, self::IF_LESS => 4, self::IF_EQUAL => 4,
        self::REL_BASE => 2, self::END => 0,
    ];

    public const END_OF_PROGRAM = null;

    /** @var int[] */
    private array $input;

    /** @var int[] */
    private array $program;

    /** @var int */
    private int $pointer = 0;

    /** @var int */
    private int $relative_base = 0;

    /**
     * @param int[] $program Program
     * @param int[] $input List of input
     */
    public function __construct(array $program, array $input = [])
    {
        $this->program = $program;
        $this->input = $input;
    }

    /**
     * Get the current state of the program
     *
     * @return int[] Program
     */
    public function getProgram(): array
    {
        return $this->program;
    }

    /**
     * Add one integer to the input list
     *
     * @param int $input Integer for input list
     */
    public function addInput(int $input): void
    {
        $this->input[] = $input;
    }

    /**
     * Run the program until it stops, then return the last output
     *
     * @return int|null Last output, or null if there was not output
     */
    public function runToLastOutput(): ?int
    {
        $output = null;
        while (($res = $this->process()) !== null) {
            $output = $res;
        }
        return $output;
    }

    /**
     * Run the program until it stops
     *
     * @return int[]
     */
    public function runToEnd(): array
    {
        $output = [];
        while (($res = $this->process()) !== null) {
            $output[] = $res;
        }
        return $output;
    }

    /**
     * Run the program and give the output, or null when stopped
     *
     * @return int|null The output value of the program, or null if the program stopped
     */
    public function process(): ?int
    {
        // loop over the program
        while (true) {
            $instruction = $this->program[$this->pointer] % 100;
            if(!isset(self::LENGTH[$instruction])) {
                throw new RuntimeException("Invalid instruction " . $instruction . " on pos " . $this->pointer);
            }

            $param_pointer = [];
            // determine parameters, and their absolute or relative position
            for ($i = 1; $i < self::LENGTH[$instruction]; $i++) {
                switch ((int)floor($this->program[$this->pointer] / (10 ** (1 + $i))) % 10) {
                    case self::M_POS;
                        $param_pointer[$i] = $this->program[$this->pointer + $i];
                        break;
                    case self::M_IMM;
                        $param_pointer[$i] = $this->pointer + $i;
                        break;
                    case self::M_REL:
                        $param_pointer[$i] = $this->relative_base + $this->program[$this->pointer + $i];
                        break;
                    default:
                        throw new RuntimeException("Invalid mode for parameter " . $i . " in position " . $this->pointer);
                }

                if ($param_pointer[$i] < 0) {
                    throw new RuntimeException("Negative parameter pointer " . $i . " in position " . $this->pointer);
                }

                // init new entries in the program array
                if ($this->program[$param_pointer[$i]] === null) {
                    $this->program[$param_pointer[$i]] = 0;
                }

            }

            // increment steps bases on the type of instruction
            $this->pointer += self::LENGTH[$instruction];

            // handle the instruction
            switch ($instruction) {
                case self::ADD:
                    $this->program[$param_pointer[3]] = $this->program[$param_pointer[1]] + $this->program[$param_pointer[2]];
                    break;
                case self::MULTIPLY:
                    $this->program[$param_pointer[3]] = $this->program[$param_pointer[1]] * $this->program[$param_pointer[2]];
                    break;
                case self::INPUT:
                    $this->program[$param_pointer[1]] = array_shift($this->input);
                    break;
                case self::JUMP_TRUE:
                    if ($this->program[$param_pointer[1]] !== 0) {
                        $this->pointer = $this->program[$param_pointer[2]];
                        // after a jump we continue directly to processing the new instruction and not to increment
                        // the program counter.
                        continue 2;
                    }
                    break;
                case self::JUMP_FALSE:
                    if ($this->program[$param_pointer[1]] === 0) {
                        $this->pointer = $this->program[$param_pointer[2]];
                        // same as previous jump
                        continue 2;
                    }
                    break;
                case self::IF_LESS:
                    $this->program[$param_pointer[3]] = $this->program[$param_pointer[1]] < $this->program[$param_pointer[2]] ? 1 : 0;
                    break;
                case self::IF_EQUAL:
                    $this->program[$param_pointer[3]] = $this->program[$param_pointer[1]] === $this->program[$param_pointer[2]] ? 1 : 0;
                    break;
                case self::OUTPUT:
                    return $this->program[$param_pointer[1]];
                case self::REL_BASE:
                    $this->relative_base += $this->program[$param_pointer[1]];
                    break;
                case self::END:
                    break 2;
            }
        }

        // end of program
        return null;
    }
}