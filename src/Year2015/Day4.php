<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2015;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2015
 */
class Day4 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // key input key
        $key = \trim($this->getInput());

        // init output
        $output1 = null;
        $output2 = null;

        // loop while results are found
        $x = 0;
        while (++$x) {
            // generate hash
            $hash = \md5($key . $x);

            // detect first answer with 5 zeroes
            if ($output1 === null && \strpos($hash, "00000") === 0) {
                $output1 = $x;
            }

            // detect second answer with 6 zeroes
            if ($output2 === null && \strpos($hash, "000000") === 0) {
                $output2 = $x;
                break;
            }
        }

        // return answers
        return
            [
                $output1,
                $output2,
            ];
    }
}