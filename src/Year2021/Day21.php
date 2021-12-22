<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2021;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2021
 */
class Day21 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $initial_pos = array_map(function ($in) {
            return intval(substr($in, -1));
        }, explode("\n", trim($this->getInput())));

        $score = [0, 0];
        $die_rolls = 1;

        $pos = $initial_pos;
        while (true) {
            foreach ([0, 1] as $player) {
                $roll = [];
                $roll[] = $die_rolls++ % 100;
                $roll[] = $die_rolls++ % 100;
                $roll[] = $die_rolls++ % 100;
                $pos[$player] = (($pos[$player] + array_sum($roll) - 1) % 10) + 1;
                $score[$player] += $pos[$player];
                //echo "Player $player rolls " . join("+", $roll) . " and moves to space " . $pos[$player] . " for a total score of " . $score[$player] . PHP_EOL;
                if ($score[0] >= 1000 || $score[1] >= 1000) {
                    break 2;
                }
            }
        }
//        $winner = $score[0] >= 1000 ? 0 : 1;
        $looser = $score[0] >= 1000 ? 1 : 0;

        // init output
        $output1 = $score[$looser] * ($die_rolls - 1);
        $a = $this->recurse($initial_pos[0]);
        $b = $this->recurse($initial_pos[1]);

        $wins_a = $wins_b = 0;
        for ($c = 0; $c < count($a); $c++) {
            if ($a[$c] > $b[$c]) {
                $wins_a++;
            } else {
                $wins_b++;
            }
        }

        var_dump([$wins_a, $wins_b]);
        $output2 = max([$wins_a, $wins_b]);

        // return answers
        return
            [
                $output1,
                $output2
            ];
    }

    private function recurse(int $pos, int $score = 0, int $turns = 0): array
    {
        $turns++;

        $duration = [];

        if ($score >= 21) {
            return [$turns];
        }

        for ($d1 = 1; $d1 < 4; $d1++) {
            for ($d2 = 1; $d2 < 4; $d2++) {
                for ($d3 = 1; $d3 < 4; $d3++) {
                    $roll = $d1 + $d2 + $d3;
                    $new_pos = (($pos + $roll - 1) % 10) + 1;
                    $new_score = $score + $pos;

                    $duration[] = [...$duration, ...$this->recurse($new_pos, $new_score, $turns)];
                }
            }
        }

        return $duration;
    }
}