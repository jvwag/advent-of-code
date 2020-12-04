<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2020;

use jvwag\AdventOfCode\Assignment;

/**
 * Class Infi
 *
 * @package jvwag\AdventOfCode\Year2020
 */
class Infi extends Assignment
{
    const INPUT_LOCATION = null;

    public function run(): array
    {
        return
            [
                $this->getBagSize(17480187),
                array_map(fn($max) => $this->getBagSize($max) * 8, [4541446746, 1340891991, 747774182, 430892823, 368992140, 42708299]),
            ];
    }

    private function getBagSize($max): int
    {
        // highly unoptimized
        $i = 0;
        do {
            $i++;
            $s = ($i * $i * 5) + (0.5 * $i * ($i - 1) * 4);
        } while ($s < $max);

        return $i;
    }
}

