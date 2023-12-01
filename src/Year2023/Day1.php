<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2023;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2023
 */
class Day1 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // output will be counters, set to zero
        $output1 = $output2 = 0;
        // loop over each line of input
        foreach (explode("\n", $this->getInput()) as $line) {
            // 
            $output1 += $this->getIntegerFromFirstAndLastDigit($line);
            $output2 += $this->getIntegerFromFirstAndLastDigit($this->convertSpelledOutNumbersToNumbers($line));
        }

        // return answers
        return
            [
                $output1,
                $output2
            ];
    }

    function getIntegerFromFirstAndLastDigit(string $str): int
    {
        // strip all the non-numeral characters
        $str = preg_replace("/[a-z]/", "", $str);
        
        // get the first and last character of the string, combine, and convert to an integer
        return intval(substr($str, 0, 1) . substr($str, -1, 1));
    }

    function convertSpelledOutNumbersToNumbers(string $str): string
    {
        // define list of english written out numbers
        $numbers = [1 => "one", "two", "three", "four", "five", "six", "seven", "eight", "nine"];
        
        // do multiple replacements, so we can match 'overlapping' numbers like 'oneight' => ('1n8ight' -> '18')
        $prev_str = null;
        while ($str !== $prev_str) {
            $prev_str = $str;
            // replace a word from the numbers array with the number using a callback
            $str = preg_replace_callback("/(" . join("|", $numbers) . ")/", function ($matches) use ($numbers) {
                // replace the found written number replacing only the first letter: 'one' => '1ne', 'two' => '2wo'
                return array_search($matches[0], $numbers) . substr($matches[0], 1);
            }, $str);
        }
        return $str;
    }
}