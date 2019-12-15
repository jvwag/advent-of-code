<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2019;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2019
 */
class Day15 extends Assignment
{
    private const UP = 0;
    private const RIGHT = 1;
    private const DOWN = 2;
    private const LEFT = 3;

    private const CMD = [self::UP => 1, self::DOWN => 2, self::LEFT => 3, self::RIGHT => 4];
    private const STEP = [self::UP => [0, -1], self::RIGHT => [1, 0], self::DOWN => [0, 1], self::LEFT => [-1, 0]];

    private const WALL = 0;
    private const OXYGEN_MACHINE = 2;

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
                $this->run2($program),
            ];
    }

    public function run1(array $program): int
    {
        // crate the computer and solve the maze, returning the location of the oxygen system and the graph of the maze
        $ic = new IntcodeComputer($program);
        [$found, $graph] = $this->solve($ic);

        // calculate the shortest path (bfs) from the start to the oxygen machine
        return count(\jvwag\AdventOfCode\Year2018\Infi::bfs_path($graph, "0/0", $found)) - 1;
    }

    public function run2(array $program): int
    {
        // crate the computer and solve the maze, returning the location of the oxygen system and the graph of the maze
        $ic = new IntcodeComputer($program);
        [$found, $graph] = $this->solve($ic);

        // calculate all shortest paths to all nodes, but take the furthest node from the oxygen machine
        return array_reduce(array_keys($graph), static function ($carry, $item) use ($graph, $found) {
            return max($carry, count(\jvwag\AdventOfCode\Year2018\Infi::bfs_path($graph, $found, $item)) - 1);
        });
    }

    private function solve(IntcodeComputer $ic): array
    {
        // init vars, we will give 0,0 as processed and the state at this location
        $graph = [];
        $found = null;
        $done["0/0"] = true;
        $todo["0/0"] = [0, 0, $ic];

        // loop until we have no more nodes to process
        while ($todo) {
            // loop over all available nodes
            foreach ($todo as $id => [$x, $y, $ic]) {
                // a key name for the current x,y location
                $xy = "$x/$y";
                // loop over the different directions
                foreach (range(0, 3) as $dir) {
                    // calculate the new coordinate for the direction
                    [$new_x, $new_y] = [$x + self::STEP[$dir][0], $y + self::STEP[$dir][1]];
                    $nxy = "$new_x/$new_y";

                    // did we already process the node?
                    if (!isset($done[$nxy])) {
                        // clone the computer to save its state
                        $c = clone $ic;
                        // add the input, we translate with the CMD mapping N/E/S/W to N/S/E/W
                        $c->addInput(self::CMD[$dir]);
                        // process the computer and return the state of the new node
                        $res = $c->process();
                        // if we not hit the wall, we should process the found node
                        if ($res !== self::WALL) {
                            // add the node to the list
                            $todo[$nxy] = [$new_x, $new_y, $c];
                            // and store the new node in a graph
                            $graph[$xy][$nxy] = $nxy;
                            $graph[$nxy][$xy] = $xy;
                        }
                        // if we found the node, store its location
                        if ($res === self::OXYGEN_MACHINE) {
                            $found = $nxy;

                        }
                        // mark the node as done, so we do not process nodes twice
                        $done[$nxy] = true;
                    }
                }
                // remove the processed node from the list
                unset($todo[$xy]);
            }
        }

        // return the found location and the graph
        return [$found, $graph];
    }
}