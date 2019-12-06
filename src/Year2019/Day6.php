<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2019;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2019
 */
class Day6 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        $constellation = $this->parseInput($this->getInput());

        // return answers
        return
            [
                $this->run1($constellation),
                $this->run2($constellation),
            ];
    }

    public function run1($constellation): int
    {
        // reduce the array to the sum of all path from the object to the center
        return array_reduce($constellation, function ($carry, $obj) use ($constellation) {
            return $carry + count($this->toCOM($constellation, $obj));
        });
    }

    public function run2($constellation): int
    {
        // calculate the path from YOU and SAN to center
        $path1 = $this->toCOM($constellation, "YOU");
        $path2 = $this->toCOM($constellation, "SAN");

        // by getting the diff between two paths you get one branch starting from the common parent path
        // flipping the diff gives the other path, by adding the two we get the shortest path (and subtract two for
        // the common intersection)
        return count(array_diff($path1, $path2)) + count(array_diff($path2, $path1)) - 2;
    }

    /**
     * @param string[] $constellation List of objects (key) and its parent (value)
     * @param string $obj Starting object
     * @return string[] List of objects giving the path from the object to the central parent
     */
    public function toCOM($constellation, $obj): array
    {
        do {
            $path[] = $obj;
        } while ($obj = $constellation[$obj]);

        return $path;
    }

    /**
     * @param string $input List of lines with <VAL1>')'<VAL2>
     * @return string[] Array of lines with key <VAL2> and value <VAL1>
     */
    public function parseInput($input): array
    {
        $constellation = [];
        foreach (explode("\n", trim($input)) as $line) {
            [$x, $y] = explode(")", $line);
            $constellation[$y] = $x;
        }

        return $constellation;
    }
}