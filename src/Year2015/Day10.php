<?php

namespace jvwag\AdventOfCode\Year2015;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2015
 */
class Day10 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // trim input
        $number = \trim($this->getInput());

        // init output
        $output1 = null;
        $output2 = null;

        // make 50 passes
        for ($x = 1; $x <= 50; $x++) {
            $number = $this->lookAndSay($number);

            // The second solution requests the 40th pass
            if ($x === 40) {
                $output1 = \strlen($number) . PHP_EOL;
            }
        }

        // get the 50th pass output
        $output2 = \strlen($number);


        // return answers
        return
            [
                $output1,
                $output2,
            ];
    }

    /**
     * @param string $input
     *
     * @return string
     */
    public function lookAndSay(string $input): string
    {
        $output = "";
        $prev_char = null;
        $count = 0;

        $l = \strlen($input) + 1;
        for ($i = 0; $i < $l; $i++) {
            $new_char = null;
            if (isset($input[$i])) {
                $new_char = $input[$i];
            }

            if ($prev_char === null) {
                $prev_char = $new_char;
            }

            if ($prev_char !== $new_char) {
                $output .= $count . $prev_char;

                $prev_char = $new_char;
                $count = 0;
            }

            $count++;
        }

        return $output;
    }
}