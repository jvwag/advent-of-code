<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2020;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2020
 */
class Day2 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input to a sorted list of integers
        $input = $this->getInput();
        $list = [];
        foreach (explode("\n", trim($input)) as $line) {
            if (preg_match("/^(\d+)-(\d+) ([^:]+): (.*)$/", $line, $match)) {
                $list[] = [$match[1], $match[2], $match[3], $match[4]];
            }
        }

        // return answers
        return
            [
                $this->run1($list),
                $this->run2($list)
            ];
    }

    /**
     * @param array $list List of passwords and their policies
     * @return int Number of correct passwords
     */
    public function run1(array $list): int
    {
        $c = 0;
        foreach ($list as [$min, $max, $letter, $password]) {
            $counts = count_chars($password);
            $letter = ord($letter);
            if (isset($counts[$letter]) && $counts[$letter] >= $min && $counts[$letter] <= $max) {
                $c++;
            }
        }

        return $c;
    }

    /**
     * @param array $list List of passwords and their policies
     * @return int Number of correct passwords
     */
    public function run2(array $list): int
    {
        $c = 0;
        foreach ($list as [$pos1, $pos2, $letter, $password]) {
            if ($password[$pos1 - 1] === $letter xor $password[$pos2 - 1] === $letter) {
                $c++;
            }
        }

        return $c;
    }
}