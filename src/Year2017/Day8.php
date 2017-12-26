<?php

namespace jvwag\AdventOfCode\Year2017;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2017
 */
class Day8 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // init vars
        $regs = [];
        $max_reg = 0;

        // get input
        $lines = explode("\n", \trim($this->getInput()));
        foreach ($lines as $line) {
            // parse all lines of input code
            if (preg_match('/^([a-z]+) (inc|dec) (-?\d+) if ([a-z]+) ([<>=!]+) (-?\d+)$/', $line, $match)) {
                /** @noinspection PhpUnusedLocalVariableInspection */
                [$tmp, $set_reg, $set_op, $set_val, $comp_reg, $comp_op, $comp_val] = $match;

                // cast the values to integers
                $comp_val = (int)$comp_val;
                $set_val = (int)$set_val;

                // if a new register is detected, init to 0
                if (!isset($regs[$set_reg])) {
                    $regs[$set_reg] = 0;
                }
                // if a new register is detected, init to 0
                if (!isset($regs[$comp_reg])) {
                    $regs[$comp_reg] = 0;
                }

                // see which comparator operator is used and do the comparison
                switch ($comp_op) {
                    case ">":
                        $comp_state = $regs[$comp_reg] > $comp_val;
                        break;
                    case "<":
                        $comp_state = $regs[$comp_reg] < $comp_val;
                        break;
                    case ">=":
                        $comp_state = $regs[$comp_reg] >= $comp_val;
                        break;
                    case "<=":
                        $comp_state = $regs[$comp_reg] <= $comp_val;
                        break;
                    case "==":
                        $comp_state = $regs[$comp_reg] == $comp_val;
                        break;
                    case "!=":
                        $comp_state = $regs[$comp_reg] != $comp_val;
                        break;
                    default:
                        die("invalid input");
                }

                // if the comparator is successful
                if($comp_state) {
                    // increase or decrease the register by the given value
                    $regs[$set_reg] += ($set_op === "inc" ? 1 : -1) * $set_val;
                    // also, update the maximum value for the second part of the challenge
                    $max_reg = max($regs[$set_reg], $max_reg);
                }
            }
        }

        // return answers
        return
            [
                max($regs), // max current registry value
                $max_reg // all time highest registry value
            ];
    }
}