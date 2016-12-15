<?php

namespace jvwag\AdventOfCode\Year2016;

use jvwag\AdventOfCode\AssignmentController;
use jvwag\AdventOfCode\AssignmentInterface;

class Day10 extends AssignmentController implements AssignmentInterface
{
    const REQUESTED_VALUE_1 = 61;
    const REQUESTED_VALUE_2 = 17;

    function run()
    {
        $data = $this->assignment_downloader->getAssignmentData(10);

        $botmap = [];
        $output = [];
        foreach (explode("\n", trim($data)) as $line) {
            if (preg_match("/^value ([0-9]+) goes to bot ([0-9]+)$/", $line, $match)) {
                $botmap[$match[2]]["values"][] = $match[1];
            } elseif (preg_match("/^bot ([0-9]+) gives low to (bot|output) ([0-9]+) and high to (bot|output) ([0-9]+)/", $line, $match)) {
                if($match[2] == "bot") {
                    $botmap[$match[1]]["low_bot"] = $match[3];
                } else {
                    $botmap[$match[1]]["low_out"] = $match[3];
                }
                if($match[4] == "bot") {
                    $botmap[$match[1]]["high_bot"] = $match[5];
                } else {
                    $botmap[$match[1]]["high_out"] = $match[5];
                }
            }
        }

        $cont = true;
        while ($cont) {
            $cont = false;
            foreach ($botmap as $id => $bot) {
                if (!isset($bot["done"]) && isset($bot["values"]) && count($bot["values"]) == 2) {
                    //echo $id . ": " . join(", ", $bot["values"]) . PHP_EOL;
                    if(isset($bot["low_bot"])) {
                        $botmap[$bot["low_bot"]]["values"][] = min($bot["values"]);
                    }
                    if(isset($bot["high_bot"])) {
                        $botmap[$bot["high_bot"]]["values"][] = max($bot["values"]);
                    }
                    if(isset($bot["low_out"])) {
                        $output[$bot["low_out"]] = min($bot["values"]);
                    }
                    if(isset($bot["high_out"])) {
                        $output[$bot["high_out"]] = min($bot["values"]);
                    }
                    $botmap[$id]["done"] = true;
                    $cont = true;
                }
            }
        }

        foreach ($botmap as $id => $bot) {
            if (isset($bot["values"]) && in_array(self::REQUESTED_VALUE_1, $bot["values"]) && in_array(self::REQUESTED_VALUE_2, $bot["values"])) {
                echo $id . PHP_EOL;
                break;
            }
        }

        echo $output[0] * $output[1] * $output[2];
    }
}
