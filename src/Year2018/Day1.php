<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2018;

use ArrayIterator;
use InfiniteIterator;
use jvwag\AdventOfCode\Assignment;

/**
 * Class Day1
 *
 * @see https://adventofcode.com/2018/day/1
 * @package jvwag\AdventOfCode\Year2018
 */
class Day1 extends Assignment
{
    /** @var int Start Frequency */
    private const START_FREQUENCY = 0;

    /**
     * @return array
     */
    public function run(): array
    {
        // Get the input
        $input = trim($this->getInput());

        // Convert drift values to array
        $drifts = explode("\n", trim($input));

        // Convert drift values to integers
        $drifts = array_map("intval", $drifts);

        // return answers
        return
            [
                $this->run1($drifts),
                $this->run2($drifts),
            ];
    }

    /**
     * Part 1: Adding all values of the array to get the resulting frequency
     *
     * @param int[] $numbers Drift Numbers
     * @return int Frequency found for all numbers
     */
    public function run1(array $numbers): int
    {
        return self::START_FREQUENCY + array_sum($numbers);
    }

    /**
     * Part 2: Infinitely looping over the array until we find a previous frequency
     *
     * @param int[] $numbers Drift numbers
     * @return int First frequency found twice
     */
    public function run2(array $numbers): int
    {
        // Array of found frequencies
        $found = [];

        // The current frequency
        $frequency = self::START_FREQUENCY;

        // Infinite Iterator for looping over the numbers
        $i = new InfiniteIterator(new ArrayIterator($numbers));

        // Loop until we find a frequency stat is stored in the found array
        for ($i->rewind(); !isset($found[$frequency]); $i->next()) {
            // Store the frequency in the found array
            $found[$frequency] = true;

            // Calculate the new frequency
            $frequency += $i->current();
        }

        // Return the found frequency
        return $frequency;
    }
}