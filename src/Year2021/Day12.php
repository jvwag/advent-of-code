<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2021;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2021
 */
class Day12 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // nodes
        $nodes = [];

        // parse all lines and set fill the nodes array with neighbouring nodes
        foreach (explode("\n", trim($this->getInput())) as $line) {
            [$a, $b] = explode("-", trim($line));
            $nodes[$a][] = $b;
            $nodes[$b][] = $a;
        }

        // return answers
        return
            [
                count($this->recurse($nodes, true)),
                count($this->recurse($nodes, false))
            ];
    }

    /**
     * Recurse over an array of nodes and their connections, returning all possible paths given the limitations
     * in the assignment.
     *
     * The used_small_cave_route flag is used to indicate if a small cave can be, or has been, used twice.
     * For the first part of the assignment set this to true so the code will skip the possibility to use a small
     * cave twice.
     *
     * @param array $nodes Array of nodes with their connections
     * @param bool $already_used_small_cave_route Set to true in part one, set to false in part two
     * @param string $node Node to check in nodes list
     * @param array $path Currently processing path
     * @return array Array of path arrays that have been found given the nodes list start node
     */
    private function recurse(array $nodes, bool $already_used_small_cave_route, string $node = "start", array $path = []): array
    {
        // init an array with found paths
        $paths = [];

        // add the current node to the path
        $path[] = $node;

        // check if we are at the last node
        if ($node !== "end") {
            // nope, we will iterate over our neighbouring nodes
            foreach ($nodes[$node] as $neighbour) {
                // never go back to start
                if ($neighbour !== "start") {
                    // if the neighbour is a big cave (uppercase), or we have not been to a small cave
                    if (strtoupper($neighbour) === $neighbour || !in_array($neighbour, $path)) {
                        // we can go there and look around
                        $paths = array_merge($paths, $this->recurse($nodes, $already_used_small_cave_route, $neighbour, $path));
                    } elseif ($already_used_small_cave_route === false) {
                        // or we can visit it again if we have not visited a small cave twice (indicated by flag)
                        $paths = array_merge($paths, $this->recurse($nodes, true, $neighbour, $path));
                    }
                }
            }
        } else {
            // if we are at the end node, add this path to the list of paths and stop recursion
            $paths[] = $path;
        }

        // return all found paths
        return $paths;
    }
}