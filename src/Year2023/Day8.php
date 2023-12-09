<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2023;

use jvwag\AdventOfCode\Assignment;
use jvwag\AdventOfCode\Year2019\Day12;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2023
 */
class Day8 extends Assignment
{
    private const DIR = ["L" => 0, "R" => 1];

    /**
     * @param bool $part1 Execute part one
     * @param bool $part2 Execute part two
     * @return array
     */
    public function run(bool $part1 = true, bool $part2 = true): array
    {
        // convert input to an array of strings (lines
        $lines = explode("\n", trim($this->getInput()));

        // get the instructions and make each instruction an element of an array
        $instructions = str_split(array_shift($lines));
        $instruction_count = count($instructions);

        // initialize arrays for a map, and current node positions
        $map = $current_node_positions = [];

        // loop over all lines
        foreach ($lines as $line) {
            // match a map entry containing a node and two target nodes and store to the map array
            if (preg_match("/^(\w+)\s*=\s*\((\w+),\s*(\w+)\)$/", $line, $match)) {
                $map[$match[1]] = [$match[2], $match[3]];
                // if the source node ends with 'A' this is one of the starting positions
                if (preg_match("/^..A$/", $match[1])) {
                    $current_node_positions[] = $match[1];
                }
            }
        }

        // because the unittest have example code that does not handle cases of part1 and part2
        // each part is implemented separately
        $steps_until_end = 0;
        if ($part1) {
            // for the first part we iterate over the map as many times is needed
            // to get from 'AAA' to 'ZZZ', while storing the counter of steps
            $node = "AAA";
            while ($node !== "ZZZ") {
                // update the node with the following node based on the instruction
                $node = $map[$node][self::DIR[$instructions[$steps_until_end++ % $instruction_count]]];
            }
        }

        // init and flag for part 2
        $steps_when_all_nodes_end = 0;
        if ($part2) {
            // init step counter and array of steps
            $step = 0;
            $ending_steps = [];
            // loop over the instructions until each node has found its end at least once
            while ($current_node_positions) {
                // lookup the instruction based on the step position, and increment the step
                $instruction = $instructions[$step++ % $instruction_count];
                // loop over all nodes that we are still processing
                foreach ($current_node_positions as $k => &$node) {
                    // update the node with the following node based on the instruction
                    $node = $map[$node][self::DIR[$instruction]];
                    // see if the node is at its end, and store its position and remove the node from nodes to follow
                    if ($node[2] === "Z") {
                        unset($current_node_positions[$k]);
                        $ending_steps[] = $step;
                    }
                }
            }
            // the answer is the largest common multiplication of the found ending positions
            // this was more of an assumption based on previous assignments
            $steps_when_all_nodes_end = Day12::array_lcm($ending_steps);
        }

        // return answers
        return
            [
                $steps_until_end,
                $steps_when_all_nodes_end
            ];
    }
}