<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2016;

use jvwag\AdventOfCode\Assignment;

/**
 * Class Day7
 *
 * @package jvwag\AdventOfCode\Year2016
 */
class Day7 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        $data = $this->getInput();

        $count1 = 0;
        $count2 = 0;

        $regex = "/\\[([^\\]]+)\\]/";
        foreach (explode("\n", trim($data)) as $outer) {
            preg_match_all($regex, $outer, $match);
            foreach ($match[0] as $str) {
                $outer = str_replace($str, ",", $outer);
            }
            $inner = implode(",", $match[1]);


            if ($this->findABBA($outer) && !$this->findABBA($inner)) {
                $count1++;
            }

            foreach ($this->findABA($outer) as $seq) {
                if (strpos($inner, $seq[1] . $seq[0] . $seq[1]) !== false) {
                    $count2++;
                    break;
                }
            }

        }

        return
            [
                $count1,
                $count2,
            ];
    }

    /**
     * @param $str
     *
     * @return array
     */
    private function findABBA($str): array
    {
        $out = [];
        for ($x = 0; $x < \strlen($str) - 3; $x++) {
            if ($str[$x + 0] !== $str[$x + 1] && $str[$x + 0] === $str[$x + 3] && $str[$x + 1] === $str[$x + 2]) {
                $out[$x] = substr($str, $x, 4);
            }
        }

        return $out;
    }

    /**
     * @param $str
     *
     * @return array
     */
    private function findABA($str): array
    {
        $out = [];
        for ($x = 0; $x < \strlen($str) - 2; $x++) {
            if ($str[$x + 0] !== $str[$x + 1] && $str[$x + 0] === $str[$x + 2]) {
                $out[$x] = substr($str, $x, 3);
            }
        }

        return $out;
    }
}