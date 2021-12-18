<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2021;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2021
 */
class Day18 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $input = explode("\n", trim($this->getInput()));

        $sum = $this->add_and_reduce($input);
        $output1 = $this->calculate_magnitude($sum);

        // init output
        $output2 = null;

        // return answers
        return
            [
                $output1,
                $output2
            ];
    }

    public function calculate_magnitude(string $input): int
    {
        while(preg_match("/\[(\d+),(\d+)\]/", $input, $match)) {
            $input = preg_replace("/".preg_quote($match[0])."/", (string)((3 * $match[1]) + (2 * $match[2])), $input, 1);
        }

        return (int)$input;
    }

    public function add_and_reduce(array $numbers): string
    {

        $output = null;
        foreach ($numbers as $number) {
            if (!$output) {
                $output = $number;
            } else {
//                echo "  " . $output . PHP_EOL;
//                echo "+ " . $number . PHP_EOL;
                $output = $this->add($output, $number);
                $output = $this->reduce($output);
//                echo "= " . $output . PHP_EOL;
            }
//            echo PHP_EOL;

        }

        return $output;
    }

    public function reduce(string $input): string
    {
//        echo "  input: " . $input . PHP_EOL;
        $prev_input = null;
        while ($prev_input !== $input) {
            $prev_input = $input;

            $input = $this->explode($input);
            if ($prev_input !== $input) {
//                echo "explode: " . $input . PHP_EOL;
                continue;
            }

            $input = $this->split($input);
            if ($prev_input !== $input) {
//                echo "  split: " . $input . PHP_EOL;
            }
        }


        return $input;
    }

    public function add(string $a, string $b): string
    {
        return "[" . $a . "," . $b . "]";
    }

    public function explode($input)
    {
        $depth = 0;
        foreach (str_split($input) as $pos => $char) {
            if ($char === "[") {
                $depth++;
            } elseif ($char === "]") {
                $depth--;
            }
            if ($depth > 4 && $input[$pos + 1] !== "[") {
                if (preg_match("/^\[(\d+),(\d+)]/", substr($input, $pos))) {
//                    echo "explode at depth: " . $depth . PHP_EOL;
                    $start_pos = $pos;
                    $end_pos = strpos($input, "]", $start_pos);

//                    echo "explode: " . substr($input, $start_pos + 1, $end_pos - $start_pos - 1) . PHP_EOL;
                    [$value_left, $value_right] = array_map("intval", (explode(",", substr($input, $start_pos + 1, $end_pos - $start_pos - 1))));

                    $input = substr_replace($input, "0", $start_pos, $end_pos - $start_pos + 1);

                    if (preg_match("/(\d+)([\[\],]+)$/", substr($input, 0, $start_pos), $match)) {
                        $prev_value_len = strlen($match[1]);
                        $prev_value_start_pos = $prev_value_len + strlen($match[2]);
                        $prev_value = intval($match[1]);
                        $new_value = (string)($prev_value + $value_left);
                        $input = substr_replace($input, $new_value, $start_pos - $prev_value_start_pos, $prev_value_len);
                        $start_pos += strlen($new_value) - $prev_value_len;
                    }

                    if (preg_match("/^([\[\],]+)(\d+)/", substr($input, $start_pos + 1), $match)) {
                        $next_value_len = strlen($match[2]);
                        $next_value_start_pos = strlen($match[1]) + 1;
                        $next_value = intval($match[2]);
                        $input = substr_replace($input, (string)($next_value + $value_right), $start_pos + $next_value_start_pos, $next_value_len);
                    }
                    break;
                } else {
//                    echo "no explode at ".substr($input, $pos).PHP_EOL;
                }
            }
        }
        return $input;
    }

    public function split($input)
    {

        if (preg_match("/(\d\d+)/", $input, $match)) {
            $input = preg_replace("/(\d\d+)/", "[" . floor($match[1] / 2) . "," . ceil($match[1] / 2) . "]", $input, 1);
        }

        return $input;
    }
}