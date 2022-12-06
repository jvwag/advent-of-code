<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2022;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2022
 */
class Day6 extends Assignment
{
    public function run(): array
    {
        $input = $this->getInput();

        // return answers
        return
            [
                $this->findFirstPositionOfUniqueCharacters($input, 4),
                $this->findFirstPositionOfUniqueCharacters($input, 14),
            ];
    }

    function findFirstPositionOfUniqueCharacters(string $input, int $length): ?int
    {
        // loop over all groups of characters starting first possible position
        for ($i = $length; $i < strlen($input); $i++) {
            // look back and count the number of unique characters from position back to $length
            // if the number of unique characters is equal to the given $length we have found a unique string
            if (count(count_chars(substr($input, $i - $length, $length), 1)) === $length) {
                return $i;
            }
        }
        // no sting with $length unique characters found
        return null;
    }
}