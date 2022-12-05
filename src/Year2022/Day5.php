<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2022;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2022
 */
class Day5 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // initialize an array of stacks and commands, this is our input
        $stacks = $commands = [];

        // loop over all lines
        foreach (explode("\n", trim($this->getInput(), "\n")) as $line) {
            // if it is a stack line, extract the crates
            if (preg_match_all("/[\[? ]([A-Z ]). ?/", $line, $match)) {
                // loop over all the crates
                foreach ($match[1] as $i => $crate) {
                    // dont stack empty crates ;)
                    if ($crate !== " ") {
                        // the stacks are counted from 1
                        $stacks[$i + 1][] = $crate;
                    }
                }
            } elseif (preg_match("/move (\d+) from (\d+) to (\d+)/", $line, $match)) {
                // this is a command line, extract the values: [count, from, to]
                $commands[] = [intval($match[1]), intval($match[2]), intval($match[3])];
            }
        }

        // sort the stacks, we will be needing to extract the answer in order later
        ksort($stacks);
        // copy the stacks to do different operations on them
        $part1_stacks = $part2_stacks = $stacks;

        // loop over all commands
        foreach ($commands as $command) {
            // execute the command in two ways with the CrateMover 9000 and the CrateMover 9001 method :D
            $this->move_multiple($part1_stacks, true, ...$command);
            $this->move_multiple($part2_stacks, false, ...$command);
        }

        // return answers
        return
            [
                // extract the last item of each stack and concatenate it to a string
                array_reduce($part1_stacks, function ($output, $a) {
                    return $output . reset($a);
                }, ""),
                array_reduce($part2_stacks, function ($output, $a) {
                    return $output . reset($a);
                }, "")
            ];
    }

    /**
     * Move multiple crates from one stack to another
     *
     * Ordered will indicate if the operations need to be done one-by-one, or using one operation
     *
     * @param array $stacks Array of stacks, will be edited in place
     * @param bool $ordered True is the CrateMover 9000 method, false the CrateMover 9001 method...
     * @param int $count The number of crates
     * @param int $from Stack number to move the crates away from
     * @param int $to Stack number to move the crates to
     * @return void
     */
    private function move_multiple(array &$stacks, bool $ordered, int $count, int $from, int $to): void
    {
        // extract a piece of the stack we need
        $extract = array_splice($stacks[$from], 0, $count);

        // and place it back on the to stack
        // the different stacking methods are just the reverse of the extracted stack
        array_unshift($stacks[$to], ...($ordered ? array_reverse($extract) : $extract));
    }
}