<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2017;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2017
 */
class Day7 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // get input
        $lines = explode("\n", \trim($this->getInput()));

        // init vars
        $nodes = [];
        $all_children = [];

        // loop over all lines
        foreach ($lines as $line) {
            // parse the line by splitting the node, weight and its children
            if (preg_match("/([a-z]+)\s*\((\d+)\)(.*)/", $line, $match)) {
                /** @noinspection PhpUnusedLocalVariableInspection */
                [$tmp, $node, $weight] = $match;
                $children = [];
                // parse the children block and clean up
                if ($match[3] && preg_match("/^\s*->\s*(.*)/", $match[3], $match)) {
                    $children = array_map("\\trim", explode(",", $match[1]));
                    // keep a list of all children so we can easily determine the only node that is not a child (the parent)
                    /** @noinspection SlowArrayOperationsInLoopInspection */
                    $all_children = array_merge($all_children, $children);
                }
                // store all nodes
                $nodes[$node] = ["weight" => (int)$weight, "children" => $children];
            }
        }

        // pre-calculate all combined tree weights
        foreach ($nodes as $node => $properties) {
            $nodes[$node]["combined_weight"] = $this->getWeight($node, $nodes);
        }

        // determine root by comparing a list of all children to the list of all nodes
        $tmp = array_diff(array_keys($nodes), $all_children);
        $root = array_pop($tmp);

        $balance = 0;
        $diff = 0;
        // traverse all nodes, starting with the root node
        $node = $root;
        while (true) {
            // determine an array of the combined weights of the children
            $weights = [];
            foreach ($nodes[$node]["children"] as $child) {
                $weights[$child] = $nodes[$child]["combined_weight"];
            }

            // the max and min weight will tell if the tree is imbalanced
            $min_weight = min($weights);
            $max_weight = max($weights);

            // if it is balanced, the previous branch must have been crooked
            if ($min_weight === $max_weight) {
                // the diff is between the nodes weight and
                $balance = $nodes[$node]["weight"] - $diff;
                break;
            }

            // the difference is stored if the next step determines the tree is balanced
            $diff = $max_weight - $min_weight;

            // and we continue with the node that was unbalanced by looking up the node with the max weight
            $node = array_search($max_weight, $weights, true);
        }

        // return answers
        return
            [
                $root,
                $balance,
            ];
    }

    /**
     * Recursive function the calculate the combined weight of all children
     *
     * @param string $node
     * @param array $nodes Nodes array with the node name as key and weight(int) and children(array) as elements
     * @return int Combined weight
     */
    private function getWeight($node, $nodes): int
    {
        $weight = $nodes[$node]["weight"];
        foreach ($nodes[$node]["children"] as $child) {
            $weight += $this->getWeight($child, $nodes);
        }

        return $weight;
    }
}