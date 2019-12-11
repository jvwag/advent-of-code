<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2019;

use jvwag\AdventOfCode\Assignment;
use jvwag\AdventOfCode\Year2015\Day9;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2019
 */
class Day7 extends Assignment
{
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
                $this->run1($program),
                $this->run2($program)
            ];
    }

    public function run1(array $program): int
    {
        $answers = [];
        // loop over all permutations of amplifiers numbered 0 to 4
        foreach (Day9::permutations(range(0, 4)) as $amplifier_phases) {
            // initial input signal is 0
            $signal = 0;
            // create a number of amplifiers equal to the number of phases
            foreach ($amplifier_phases as $phase_setting) {
                // and use the phase setting for this amp, and the signal of the previous amp
                $amplifier = new IntcodeComputer($program, [$phase_setting, $signal]);

                // now resolve the program and get the first output (this program has one output, we dont bother to
                // wait until the end of the application)
                $signal = $amplifier->process();

            }
            // use the given signal of the last amplifier as an answer of this permutation
            $answers[] = $signal;
        }

        // return the highest value of our possible outcomes
        return max($answers);
    }

    public function run2(array $program)
    {
        $answers = [];
        // again, loop over all permutations of amplifiers but now numbered 5 to 9
        foreach (Day9::permutations(range(5,9)) as $amplifier_phases) {
            // initial input signal is 0
            $signal = 0;
            // clear amplifier list for this iteration
            /** @var IntcodeComputer[] $amp_computer */
            $amp_computer = [];
            // loop until one program stops
            while (true) {
                // loop over the number of amplifiers to process them in order
                foreach($amplifier_phases as $i => $phase_setting) {
                    // if not exists, we will create an amplifier using a IntcodeComputer, and start the process
                    if (!isset($amp_computer[$i])) {
                        // use the phase from the permutations
                        $amp_computer[$i] = new IntcodeComputer($program, [$phase_setting]);
                    }
                    // add the signal from the previous output, or 0 for the first one
                    $amp_computer[$i]->addInput($signal);

                    // the process function should have ran until the first yield, which is our output needed for the
                    // next signal
                    $res = $amp_computer[$i]->process();

                    // the result of the output could be null, and this indicates the process() function is done
                    if ($res === null) {
                        // than we use the last given signal and break back to the permutation iteration phase
                        $answers[] = $signal;
                        break 2;
                    }

                    // but if it was a intermediate return, this is the signal to hand over to our next amplifier
                    $signal = $res;
                }
            }
        }

        // return the highest value of our possible outcomes
        return max($answers);
    }
}