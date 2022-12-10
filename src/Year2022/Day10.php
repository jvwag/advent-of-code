<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2022;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2022
 */
class Day10 extends Assignment
{
    public function run(): array
    {
        // parse commands
        $commands = array_map(function ($line) {
            return explode(" ", trim($line));
        }, explode("\n", trim($this->getInput())));


        // init buffers and counters
        $cycle = $signal_strength_sum = $buffer = 0;
        $command_cycles = $x = 1;
        $display = "";

        // loop cycles while there are still commands to be processed
        while ($commands) {
            // increase cycle counter
            $cycle++;
            // decrease command cycle counter (the number of cycles to wait until a command is finished)
            $command_cycles--;

            // if the command cycle counter is 0 the previous command is finished
            if ($command_cycles === 0) {
                // write the buffer of the previous command to the registry
                $x += $buffer;
                // fetch the command from the array
                $command = array_shift($commands);
                // determine what to do
                switch ($command[0]) {
                    case "addx":
                        // add the argument value to the buffer
                        $buffer = intval($command[1]);
                        // and set the command cycles
                        $command_cycles = 2;
                        break;
                    case "noop":
                        // a noop will not add anything to the buffer
                        $buffer = 0;
                        // and will only take one cycle
                        $command_cycles = 1;
                        break;
                }
            }

            // if we are on a step of 40 cycles, but starting to count from 20
            if ($cycle >= 20 && ($cycle - 20) % 40 === 0) {
                // add the product of the cycle and register value to the answer of part 1
                $signal_strength_sum += $cycle * $x;
            }

            // for part 2 we will fill a display grid (a string), we will cut it up in rows of 40 chars later
            // due to using modulus 40 we must adjust the cycle and registry offset to zero (now we are counting
            // up from 1)... if we do not do this tiny errors around the edges will occur
            $cycle0 = ($cycle - 1) % 40;
            $x0 = $x - 1;

            // add a "#" or "." to the display sting determined if the horizontal position overlays
            // with the sprite (from $x to $x + 2) position
            $display .= ($cycle0 >= $x0 && $cycle0 <= $x0 + 2) ? "#" : ".";
        }

        // return answers
        return
            [
                $signal_strength_sum,
                // split the display string in rows of 40 length
                join(PHP_EOL, str_split($display, 40))
            ];
    }
}