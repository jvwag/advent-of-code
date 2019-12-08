<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2019;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2019
 */
class Day8 extends Assignment
{
    private const MAX_X = 25;
    private const MAX_Y = 6;

    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $layers = str_split(trim($this->getInput()), self::MAX_X * self::MAX_Y);

        // return answers
        return
            [
                $this->run1($layers),
                $this->run2($layers, self::MAX_X),
            ];
    }

    public function run1($layers): int
    {
        // init vars
        $output = 0;
        $min_zeros = PHP_INT_MAX;

        // loop over all layers
        foreach($layers as $layer) {
            // count chars in layers
            $c = count_chars($layer, 1);
            if ($c[48] < $min_zeros) {
                // determine if this could be the layer with the least zeros (ascii char 48 is "0")
                $min_zeros = $c[48];
                // calculate the output (ascii char 49 and 50 are "1" and "2")
                $output = $c[49] * $c[50];
            }
        }

        // the last calculated value is the layer with the least zeros
        return $output;
    }

    public function run2($layers, $x_size): string
    {
        $final_layer = "";
        // loop over the layers, reversed
        foreach (array_reverse($layers) as $layer) {
            // loop over all pixels
            foreach (str_split($layer) as $x => $pixel) {
                // if the pixel is not transparent overwrite the final layer
                if ($pixel !== "2") {
                    $final_layer[$x] = $pixel;
                }
            }
        }

        // format output: split the string in rows, join with newlines and replace chars so only pixel 1 will light up
        return rtrim(str_replace(["0", "1", "2"], [" ", "\u{2588}", " "], implode(PHP_EOL, str_split($final_layer, $x_size))));
    }
}