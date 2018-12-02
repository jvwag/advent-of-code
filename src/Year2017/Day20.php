<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2017;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2017
 */
class Day20 extends Assignment
{
    // yes, I solved this iteratively... I know it could be done by math but its just not my strongest suit
    // test if 500 passes will give the same output as 1000 passes if the answer is not correct
    private const PASSES = 500;

    /**
     * @return array
     */
    public function run(): array
    {
        // return answers
        return
            [
                $this->run1($this->getInput()), // least far away particle from (0,0,0)
                $this->run2($this->getInput())  // number of particles that did not collide
            ];
    }

    /**
     * @param string $input List of all particles as given in the assignment
     * @return array[] Array of arrays with three elements, p(os), v(ector) and , a(cceleration), each with x, y and z
     */
    private function convertInput($input): array
    {
        // convert input
        $particles = [];
        // loop over all lines
        foreach (explode("\n", trim($input)) as $line) {
            // parse one line and store it in particles
            if (preg_match("/^p=<(-?\d+),(-?\d+),(-?\d+)>, v=<(-?\d+),(-?\d+),(-?\d+)>, a=<(-?\d+),(-?\d+),(-?\d+)>$/", $line, $match)) {
                /** @todo remove noinspection and $tmp after fix for https://youtrack.jetbrains.com/issue/WI-34517 */
                /** @noinspection PhpUnusedLocalVariableInspection */
                [$tmp, $p["p"]["x"], $p["p"]["y"], $p["p"]["z"], $p["v"]["x"], $p["v"]["y"], $p["v"]["z"], $p["a"]["x"], $p["a"]["y"], $p["a"]["z"]] = $match;
                $particles[] = $p;
            }
        }

        // return all particles
        return $particles;
    }

    /**
     * @param string $input List of all particles as given in the assignment
     * @return int Particle number that is closest to (0, 0, 0)
     */
    public function run1($input): int
    {
        // get all particles in an array
        $particles = $this->convertInput($input);

        $distance = [];
        // loop over all particles to calculate its distance after x passes
        foreach ($particles as $p => $particle) {
            // update the position each pass
            for ($x = 0; $x < self::PASSES; $x++) {
                $particle["v"]["x"] += $particle["a"]["x"];
                $particle["v"]["y"] += $particle["a"]["y"];
                $particle["v"]["z"] += $particle["a"]["z"];
                $particle["p"]["x"] += $particle["v"]["x"];
                $particle["p"]["y"] += $particle["v"]["y"];
                $particle["p"]["z"] += $particle["v"]["z"];
            }
            // calculate the distance after x passes
            $distance[$p] = array_sum(array_map("\abs", $particle["p"]));
        }

        // determine the smallest distance
        return (int)array_search(min($distance), $distance, true);
    }

    public function run2($input): int
    {
        // get all particles in an array
        $particles = $this->convertInput($input);

        // loop for a determined amount of passes
        for ($x = 0; $x < self::PASSES; $x++) {
            // first update the position of each particle
            foreach ($particles as $p => &$particle) {
                $particle["v"]["x"] += $particle["a"]["x"];
                $particle["v"]["y"] += $particle["a"]["y"];
                $particle["v"]["z"] += $particle["a"]["z"];
                $particle["p"]["x"] += $particle["v"]["x"];
                $particle["p"]["y"] += $particle["v"]["y"];
                $particle["p"]["z"] += $particle["v"]["z"];

            }
            // unset 'particle' because we used it as a reference
            unset($particle);

            // then look for collisions, comparing all particles
            foreach ($particles as $p1 => $particle1) {
                foreach ($particles as $p2 => $particle2) {
                    // if we have found a collision
                    if ($p1 !== $p2 && $particle1["p"] === $particle2["p"]) {
                        // unset the particles
                        unset($particles[$p1], $particles[$p2]);
                    }
                }
            }
        }

        // count the number of particles left
        return \count($particles);
    }
}