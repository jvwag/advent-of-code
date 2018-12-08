<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2018;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2018
 */
class Day8 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // get input and convert to array of integers
        $input = array_map("intval", explode(" ", trim($this->getInput())));

        // parse all nodes
        $nodes = $this->parseNodes($input);

        // return answers
        return
            [
                array_sum(array_column($nodes, "part_1_sum")), // sum of all part1 sums in every node
                end($nodes)["part_2_sum"] // only the part2 sum of the root node
            ];
    }

    private function parseNodes(array &$input, int $depth = 0)
    {
        // get the number of child nodes and the number of metadata entries, and remove them from the input
        $number_of_child_nodes = array_shift($input);
        $number_of_metadata_entries = array_shift($input);

        // loop over the number of child nodes with recursion
        $nodes = [[]];
        for ($x = 0; $x < $number_of_child_nodes; $x++) {
            $nodes[] = $this->parseNodes($input, $depth + 1);
        }
        // merge the found nodes in the list
        $nodes = array_merge(... $nodes);

        // now get all the metadata entries and remove them from the input
        $metadata_entries = [];
        for ($x = 0; $x < $number_of_metadata_entries; $x++) {
            $metadata_entries[] = array_shift($input);
        }

        // part 1 wants the sum of metadata entries
        $part_1_sum = array_sum($metadata_entries);

        // part 2 could also be the sum of metadata entries
        $part_2_sum = $part_1_sum;

        // or, if we have child nodes
        if ($nodes) {
            // the part 2 sum will be different
            $part_2_sum = 0;
            // take all directly connected child nodes
            $direct_children = array_values(array_filter($nodes, function ($arr) use ($depth) {
                return $arr["depth"] === $depth + 1;
            }));
            // and see if a metadata entry points to one of these children
            foreach ($metadata_entries as $metadata_entry) {
                // now we add the part 2 sum of entries pointing to existing children and add them to our part 2 sum
                if (isset($direct_children[$metadata_entry - 1])) {
                    $part_2_sum += $direct_children[$metadata_entry - 1]["part_2_sum"];
                }
            }
        }

        // return the part 1 sum, part 2 sum and the depth (needed for identifying directly connected nodes)
        return array_merge($nodes, [["part_1_sum" => $part_1_sum, "part_2_sum" => $part_2_sum, "depth" => $depth]]);
    }
}