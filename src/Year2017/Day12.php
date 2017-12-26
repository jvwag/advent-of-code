<?php

namespace jvwag\AdventOfCode\Year2017;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2017
 */
class Day12 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        $programs = $solutions = [];

        // convert input to a programs array
        $lines = explode("\n", trim($this->getInput()));
        foreach ($lines as $line) {
            if (preg_match('/^(\d+) <-> (.*)$/', $line, $match)) {
                $programs[(int)$match[1]] = array_map("\intval", explode(", ", $match[2]));
            }
        }

        // start with program 0
        $node = 0;
        while($programs) {
            // make an array with groups of connected programs
            $solutions[$node] = $this->getConnections($node, $programs);

            // remove all children from the programs list to never have to count them again
            foreach($solutions[$node] as $child) {
                unset($programs[$child]);
            }

            // get the first program as the new start node
            reset($programs);
            $node = key($programs);
        }

        // return answers
        return
            [
                count($solutions[0]), // number of programs connected to program 0
                count($solutions), // number of program groups
            ];
    }

    /**
     * Get all connections to programs with the given number
     *
     * @param int $node Start node
     * @param array[] $programs Array of programs, with the key as the program number and the value an array of program numbers connected
     * @param int[] $found Internal state
     * @return int[] The connections to the given start node
     */
    private function getConnections($node, $programs, &$found = [])
    {
        // add the node to the connected programs list
        $found[$node] = $node;

        // loop over its children
        foreach ($programs[$node] as $child) {
            // if we have not seen this child yet
            if (!isset($found[$child])) {
                // call our self to add its children
                $this->getConnections($child, $programs, $found);
            }
        }
        return $found;
    }
}