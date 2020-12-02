<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2016;

use jvwag\AdventOfCode\Assignment;

/**
 * Class Day3
 *
 * @package jvwag\AdventOfCode\Year2016
 */
class Day3 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        $data = $this->getInput();

        $valid1 = 0;
        $valid2 = 0;
        foreach (explode("\n", trim($data)) as $line) {
            if (preg_match("/(\d+)\\s+(\d+)\\s+(\d+)/", $line, $sides)) {
                if ($this->validTriangle($sides[1], $sides[2], $sides[3])) {
                    $valid1++;
                }

                $col[0][] = $sides[1];
                $col[1][] = $sides[2];
                $col[2][] = $sides[3];

                if (count($col[0]) === 3) {
                    for ($x = 0; $x < 3; $x++) {
                        if ($this->validTriangle($col[$x][0], $col[$x][1], $col[$x][2])) {
                            $valid2++;
                        }
                    }
                    $col = [];
                }
            }
        }

        return
            [
                $valid1,
                $valid2,
            ];
    }

    /**
     * @param $x
     * @param $y
     * @param $z
     *
     * @return bool
     */
    public function validTriangle($x, $y, $z): bool
    {
        foreach ([[$x, $y, $z], [$x, $z, $y], [$y, $z, $x]] as $combo) {
            if ($combo[0] + $combo[1] <= $combo[2]) {
                return false;
            }
        }

        return true;
    }
}


