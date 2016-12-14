<?php

namespace jvwag\AdventOfCode\Year2016;

use jvwag\AdventOfCode\AssignmentController;
use jvwag\AdventOfCode\AssignmentInterface;

class Day7 extends AssignmentController implements AssignmentInterface
{
    function run()
    {
        $data = $this->assignment_downloader->getAssignmentData(7);

        $count1 = 0;
        $count2 = 0;

        $regex = "/\\[([^\\]]+)\\]/";
        foreach (explode("\n", trim($data)) as $outer) {
            preg_match_all($regex, $outer, $match);
            foreach ($match[0] as $str) {
                $outer = str_replace($str, ",", $outer);
            }
            $inner = join(",", $match[1]);


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

        echo $count1 . PHP_EOL;
        echo $count2 . PHP_EOL;
    }

    private function findABBA($str)
    {
        $out = [];
        for ($x = 0; $x < strlen($str) - 3; $x++) {
            if ($str[$x + 0] != $str[$x + 1] && $str[$x + 0] == $str[$x + 3] && $str[$x + 1] == $str[$x + 2]) {
                $out[$x] = substr($str, $x, 4);
            }
        }

        return $out;
    }

    private function findABA($str)
    {
        $out = [];
        for ($x = 0; $x < strlen($str) - 2; $x++) {
            if ($str[$x + 0] != $str[$x + 1] && $str[$x + 0] == $str[$x + 2]) {
                $out[$x] = substr($str, $x, 3);
            }
        }

        return $out;
    }
}