<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2025;

use jvwag\AdventOfCode\Assignment;

class Infi extends Assignment
{
    public const INPUT_LOCATION = "infi-2025.txt";

    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $data = array_map("str_split", explode("\n", trim($this->getInput())));

        $output1 = 0;
        for ($i = 0; $i < 256; $i++) {
            $output1 += $this->grow($data, $i % 4);
        }


        // return answers
        return
            [
                $output1,
                null
            ];
    }

    private function grow(array &$old, int $direction): int
    {
        $size = count($old);
        $new = $old;
        $count = 0;
        $adjacent = [[0, -2], [1, -1], [1, 1], [0, 2], [-1, 1], [-1, -1]];
        for ($y = 0; $y < $size ; $y++) {
            for ($x = 0; $x < $size; $x++) {
                $value = $old[$y][$x];
                if ($value === " ") {
                    $new[$y][$x] = $old[$y][$x];
                    continue;
                }
                if ($direction === 0) {
                    for ($i = $y - 1; $i >= 0; $i--) {
                        if (isset($old[$i][$x]) && $old[$i][$x] !== "." && intval($old[$i][$x]) !== 0 && $old[$i][$x] >= $old[$y][$x]) {
                            $new[$y][$x] = $old[$y][$x];
                            continue 2;
                        }
                    }
                } elseif ($direction === 1) {
                    for ($i = $x + 2; $i < $size; $i = $i + 2) {
                        if (isset($old[$y][$i]) && $old[$y][$i] !== "." && intval($old[$y][$i]) !== 0 && intval($old[$y][$i]) >= intval($old[$y][$x])) {
                            $new[$y][$x] = $old[$y][$x];
                            continue 2;
                        }
                    }
                } elseif ($direction === 2) {
                    for ($i = $y + 1; $i < $size; $i++) {
                        if (isset($old[$i][$x]) && $old[$i][$x] !== "." && intval($old[$i][$x]) !== 0 && $old[$i][$x] >= $old[$y][$x]) {
                            $new[$y][$x] = $old[$y][$x];
                            continue 2;
                        }
                    }
                } elseif ($direction === 3) {
                    for ($i = $x - 2; $i >= 0; $i = $i - 2) {
                        if (isset($old[$y][$i]) && $old[$y][$i] !== "." && intval($old[$y][$i]) !== 0 && intval($old[$y][$i]) >= intval($old[$y][$x])) {
                            $new[$y][$x] = $old[$y][$x];
                            continue 2;
                        }
                    }
                }

                if ($value === ".") {
                    $c = 0;
                    foreach ($adjacent as [$x_offset, $y_offset]) {
                        if (isset($old[$y + $y_offset][$x + $x_offset]) && $old[$y + $y_offset][$x + $x_offset] >= 2) {
                            $c++;
                        }
                    }
                    if ($c >= 2) {
                        $new[$y][$x] = 0;
                    }
                } else {
                    $new[$y][$x] = $old[$y][$x] + 1;
                    if ($new[$y][$x] === 5) {
                        $new[$y][$x] = ".";
                        $count++;
                    }
                }
            }
        }
        $old = $new;
        return $count;
    }

    private function display(array $data)
    {
        foreach ($data as $row) {
            foreach ($row as $value) {
                echo $value === null ? "." : $value;
            }
            echo "\n";
        }
    }
}