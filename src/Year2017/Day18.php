<?php

namespace jvwag\AdventOfCode\Year2017;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2017
 */
class Day18 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $instructions = explode("\n", trim($this->getInput()));

        // init answers
        $last_frequency = null;
        $sent_counter = 0;

        // init vars
        $pos = $pos1 = $pos2 = $jmp1 = $jmp2 = 0;
        $frequency = $queue1 = $queue2 = $registers = [];
        $is_running = [1];
        $registers1 = ["p" => 0];
        $registers2 = ["p" => 1];

        // for part1, loop until the 'rcv' opcode 'eats' the 'is_running' queue
        do {
            $pos += $this->execute($instructions[$pos], $registers, $frequency, $is_running);
        } while ($is_running);
        // the sent queue will contain the frequency
        $last_frequency = array_pop($frequency);

        // for part 2, loop while both programs are not waiting for input (deadlock, jmp: 0)
        do {
            $jmp1 = $this->execute($instructions[$pos1 += $jmp1], $registers1, $queue1, $queue2);
            $jmp2 = $this->execute($instructions[$pos2 += $jmp2], $registers2, $queue2, $queue1, $sent_counter);
        } while ($jmp1 !== 0 || $jmp2 !== 0);

        // return answers
        return
            [
                $last_frequency,
                $sent_counter,
            ];
    }

    /**
     * @param string $instruction Instruction string
     * @param int[] $registers Registers array
     * @param int[] $send_queue Send value
     * @param int[] $receive_queue Receive value
     * @param int $sent_counter Counter for the number of sends
     * @return int New position offset
     */
    private function execute($instruction, &$registers, &$send_queue, &$receive_queue, &$sent_counter = 0)
    {
        // parse the instruction
        $parts = explode(" ", $instruction);
        $type = $parts[0];
        $reg = $parts[1];
        $value = isset($parts[2]) ? $parts[2] : null;

        // if value or reg is a registry reference and it does not exist, create it
        if (!isset($registers[$reg]) && !is_numeric($reg)) {
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
            case "add": $registers[$reg] += $fetch($value); break;
            case "mul": $registers[$reg] *= $fetch($value); break;
            case "mod": $registers[$reg] %= $fetch($value); break;
            case "jgz": if ($fetch($reg) > 0) { return $fetch($value); } break;

            // send a value to the outgoing queue and up a counter (for part 2 answer)
            case "snd": $send_queue[] = $fetch($reg); $sent_counter++; break;

            // receive a value from the receive queue
            case "rcv":
                // if the receive queue is empty, jump 0 to execute this instruction again next cycle
                if (!$receive_queue) { return 0; }
                // fetch a value from the receive queue and set it to a register
                $registers[$reg] = array_shift($receive_queue);
                break;
        }
        // @formatter:on

        // normal operations will add one to the program counter
        return 1;
    }
}