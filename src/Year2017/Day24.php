<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2017;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2017
 */
class Day24 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // fill components array with input
        $components = [];
        foreach (explode("\n", trim($this->getInput())) as $line) {
            $components[] = array_map("\intval", explode("/", trim($line)));
        }

        // init statistics
        $stats = ["strongest" => 0, "longest" => 0, "longest_strength" => 0];

        // loop over all components
        foreach ($components as $key => $component) {
            // and search for '0' in the first or second port position
            if (($pos = array_search(0, $component, true)) !== false) {
                // call the recursive function to calculate all possible connector permutations
                $this->permutate($components, $key, $component[$pos ^ 1], $component[$pos ^ 1], 1, $stats);
            }
        }

        // return answers
        return
            [
                $stats["strongest"],
                $stats["longest_strength"],
            ];
    }

    /**
     * Calculate all permutations of components of the given list, while excluding the component
     * with the key 'current_key' argument, looking for components with 'port' in the first or
     * second element of a component. A carry-in for strength and length and a carry-over for the
     * stats array.
     *
     * @param int[][] $components Array of components containing two integer elements
     * @param int $current_key Key of the current component, used to exclude from components list
     * @param int $port Port of the current component, used to match against components in the list
     * @param int $strength Carry-in value of strength of last step in the recursion
     * @param int $length Carry-in value of length of last step in the recursion
     * @param int[] $stats Carry-over array with statistics
     */
    private function permutate($components, $current_key, $port, $strength, $length, &$stats): void
    {
        // store the component and remove the current component from the components array
        $backup_component = $components[$current_key];
        unset($components[$current_key]);

        // calculate statistics
        $stats["strongest"] = max($strength, $stats["strongest"]); // determine strongest
        $stats["longest_strength"] = // determine longest_strength
            $length > $stats["longest"] ? // if we have new longest value?
                $strength : // we use the new strength
                ($length === $stats["longest"] ? // if its the same?
                    max($strength, $stats["longest_strength"]) : // we use the biggest strength
                    $stats["longest_strength"]); // else we keep the same value
        $stats["longest"] = max($length, $stats["longest"]); // determine longest

        // loop over all components
        foreach ($components as $key => $component) {
            // to see if one of th two value matches
            if (($pos = array_search($port, $component, true)) !== false) {
                // then recurse this function with the new connector, add strength and length
                $this->permutate($components, $key, $component[$pos ^ 1], $strength + $component[0] + $component[1], $length + 1, $stats);
            }
        }

        // add the removed component back to the components array
        $components[$current_key] = $backup_component;
    }
}