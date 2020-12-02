<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2015;

use jvwag\AdventOfCode\Assignment;

/**
 * Class Day1
 *
 * @package jvwag\AdventOfCode\Year2015
 */
class Day1 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input to array of characters
        $data = str_split($this->getInput());

        // init output
        $level = 0;
        $step = null;

        // loop over all characters
        foreach ($data as $z => $char) {
            // update level
            if ($char === "(") {
                $level++;
            } elseif ($char === ")") {
                $level--;
            }

            // find step where we found the first basement level
            if ($step === null && $level === -1) {
                $step = $z + 1;
            }
        }

        return
            [
                $level,
                $step
            ];
    }
}