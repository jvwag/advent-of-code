<?php

namespace jvwag\AdventOfCode\Year2016;

use jvwag\AdventOfCode\AssignmentController;
use jvwag\AdventOfCode\AssignmentInterface;

class Day9 extends AssignmentController implements AssignmentInterface
{
    function run()
    {
        $data = trim($this->assignment_downloader->getAssignmentData(9));

        for ($i = 0; $i <= strlen($data);) {
            if (preg_match("/^\\(([0-9]+)x([0-9]+)\\)/", substr($data, $i), $match)) {
                list($cmd, $len, $mul) = $match;
                $base = substr($data, $i + strlen($cmd), $len);
                $insert = str_repeat($base, $mul);
                $data = substr_replace($data, $insert, $i, strlen($cmd) + $len);
                $i += strlen($insert);
            } else {
                $i++;
            }
        }

        echo strlen($data) . PHP_EOL;
        echo $this->parsePart($data) . PHP_EOL;
    }

    function parsePart($str)
    {
        $total = 0;
        while (preg_match("/([A-Z]+)?\\(([0-9]+)x([0-9]+)\\)(.*)$/", $str, $match)) {
            list(, $prepend, $len, $mul, $rest) = $match;
            $res = $this->parsePart(substr($rest, 0, $len));
            $total += strlen($prepend) + ($res * $mul);
            $str = substr($str, strlen("(" . $len . "x" . $mul . ")") + strlen($prepend) + $len);
        }

        return strlen($str) + $total;
    }
}
