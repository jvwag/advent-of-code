<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2017;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2017
 */
class Day17 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // get input
        $steps = (int)trim($this->getInput());

        // for part 1 we create a buffer
        $buffer = [0];
        $pos = 0;
        // loop 2017 times
        for($x = 1; $x <= 2017; $x++) {
            // calculate the position of the new element
            $pos = (($pos + $steps) % $x) + 1;
            // and insert it
            array_splice($buffer, $pos, 0, $x);
        }
        // the output was the last position were we inserted 2017 plus one
        $output1 = $buffer[$pos + 1];

        // for part 2 we also loop, but without a buffer
        $pos = 0;
        // the first value after 0 is always element with position 1, so we only keep track of that value
        $output2 = null;
        // loop 50 million times
        for($x = 1; $x <= 50000000; $x++) {
            // calculate the position of the new element
            $pos = (($pos + $steps) % $x) + 1;
            // and our answer if the position is 1
            if($pos === 1) {
                $output2 = $x;
            }
        }

        // return answers
        return
            [
                $output1,
                $output2
            ];
    }
}