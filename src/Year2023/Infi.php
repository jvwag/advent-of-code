<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2023;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2023
 */
class Infi extends Assignment
{
    public const INPUT_LOCATION = "infi-2023.txt";

    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $input = $this->getInput();
        $pakjes = [];
        foreach (explode("\n", $input) as $row_id => $veelhoek) {
            preg_match_all("/\((-?\d+), (-?\d+)\)/", $veelhoek, $match);
            for ($i = 0; $i < count($match[0]); $i++) {
                $pakjes[$row_id][] = [intval($match[1][$i]), intval($match[2][$i])];
            }
        }

        $max = [];
        foreach ($pakjes as $pakje_id => $pakje) {
            $max[$pakje_id] = 0;
            foreach ($pakje as [$x, $y]) {
                    $value = sqrt((abs($x) ** 2) + (abs($y) ** 2));

                    if ($value > $max[$pakje_id]) {
                        $max[$pakje_id] = $value;
                    }
            }
        }

        // init output
        $output2 = null;

        // return answers
        return
            [
                floor(array_sum($max)),
                $output2
            ];
    }
}