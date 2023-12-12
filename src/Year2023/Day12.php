<?php
declare(strict_types=1);


namespace jvwag\AdventOfCode\Year2023;

use jvwag\AdventOfCode\Assignment;

ini_set('memory_limit', '8G');

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2023
 */
class Day12 extends Assignment
{
    private array $cache;

    /**
     * @return array
     */
    public function run(): array
    {
        $hotsprings = $records = [];
        $output1 = 0;
        foreach (explode("\n", trim($this->getInput())) as $line) {
            [$record, $size] = explode(" ", $line);
//            $record = $record."?".$record."?".$record."?".$record."?".$record;
//            $size = $size.",".$size.",".$size.",".$size.",".$size;

            $hotsprings[] = [$record, array_map("intval", explode(",", $size))];
        }

        foreach ($hotsprings as $i => [$record, $sizes]) {
            foreach ($this->generatePermutations(count($sizes), strlen($record) - array_sum($sizes)) as $permutation) {
                $possible_record = "";
                $ok = true;
                foreach ($permutation as $p_index => $spaces) {
                    if ($p_index > 0 && $p_index < count($permutation) - 1 && $spaces === 0) {
                        $ok = false;
                        break;
                    }
                    if ($spaces > 0) {
                        $possible_record .= str_repeat(".", $spaces);
                    }
                    if (isset($sizes[$p_index])) {
                        $possible_record .= str_repeat("#", $sizes[$p_index]);
                    }
                }

                if ($ok) {
                    for ($i = 0; $i < strlen($record); $i++) {
                        if ($record[$i] !== $possible_record[$i] && $record[$i] !== "?") {
                            $ok = false;
                            break;
                        }
                    }
                }

                if ($ok) {
                    $output1++;
                }
            }
        }


        // init output
        $output2 = null;

        // return answers
        return
            [
                $output1,
                $output2
            ];
    }

    private function generatePermutations($max_numbers, $sum_of_numbers, $prefix = [], $depth = 0): array
    {
        $result = [];
        if ($depth === $max_numbers) {
            $prefix[$depth] = $sum_of_numbers;
            return [$prefix];
        }

        for ($i = 0; $i <= $sum_of_numbers; $i++) {
            $prefix[$depth] = $i;
            $result = array_merge($result, $this->generatePermutations($max_numbers, $sum_of_numbers - $i, $prefix, $depth + 1));
        }

        return $result;
    }
}