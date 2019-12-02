<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2019;

use jvwag\AdventOfCode\Assignment;

/**
 * Class Infi
 *
 * @package jvwag\AdventOfCode\Year2018
 */
class Infi extends Assignment
{
    public const INPUT_LOCATION = "infi-2019.txt";

    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        /** @noinspection JsonEncodingApiUsageInspection */
        $input = json_decode($this->getInput());

        // init output
        $output1 = null;
        $output2 = null;

        // return answers
        return
            [
                $this->run1($input),
                $this->run2($input)
            ];
    }

    public function run1(object $input): int
    {
        [$loc_x, $loc_y] = $input->flats[0];
        $count = 0;
        foreach ($input->sprongen as [$jump_x, $jump_y]) {
            $count++;
            $new_x = $loc_x + $jump_x + 1;
            for ($new_y = $loc_y + $jump_y; $new_y > 0; --$new_y) {
                if (in_array([$new_x, $new_y], $input->flats, true)) {
                    [$loc_x, $loc_y] = [$new_x, $new_y];
                    continue 2;
                }
            }
            return $count;
        }
        assert(false,"No solution found");

        return 0;
    }

    public function run2($input): int
    {
        return 0;
    }
}