<?php

namespace jvwag\AdventOfCode\Year2016;

use jvwag\AdventOfCode\AssignmentController;
use jvwag\AdventOfCode\AssignmentInterface;

class Day9 extends AssignmentController implements AssignmentInterface
{
    function run()
    {
        $data = trim($this->assignment_downloader->getAssignmentData(9));
//        $data = "ABCD(8x5)A(2x9)AX(1x5)F(2x3)12";

        for($i = 0; $i <= strlen($data); ) {
            if(preg_match("/^\\(([0-9]+)x([0-9]+)\\)/", substr($data, $i), $match)) {
                list($cmd, $len, $mul) = $match;
                $base = substr($data, $i + strlen($cmd), $len);
                $insert = str_repeat($base ,$mul);
                $data = substr_replace($data, $insert, $i, strlen($cmd) + $len);
                $i += strlen($insert);
            } else {
                $i++;
            }
        }

        echo strlen($data).PHP_EOL;
    }
}