<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2016;

use jvwag\AdventOfCode\Assignment;

/**
 * Class Day10
 *
 * @package jvwag\AdventOfCode\Year2016
 */
class Day10 extends Assignment
{
    private const REQUESTED_VALUE_1 = 61;
    private const REQUESTED_VALUE_2 = 17;

    /**
     * @return array
     */
    public function run(): array
    {
        $data = $this->getInput();

        $map = [];
        $output = [];
        foreach (explode("\n", trim($data)) as $line) {
            if (preg_match("/^value (\d+) goes to bot (\d+)$/", $line, $match)) {
                $map[$match[2]]["values"][] = (int) $match[1];
            } elseif (preg_match("/^bot (\d+) gives low to (bot|output) (\d+) and high to (bot|output) (\d+)/", $line, $match)) {
                if ($match[2] === "bot") {
                    $map[$match[1]]["low_bot"] = (int) $match[3];
                } else {
                    $map[$match[1]]["low_out"] = (int) $match[3];
                }
                if ($match[4] === "bot") {
                    $map[$match[1]]["high_bot"] = (int) $match[5];
                } else {
                    $map[$match[1]]["high_out"] = (int) $match[5];
                }
            }
        }

        $cont = true;
        while ($cont) {
            $cont = false;
            foreach ($map as $id => $bot) {
                if (!isset($bot["done"]) && isset($bot["values"]) && \count($bot["values"]) === 2) {
                    if (isset($bot["low_bot"])) {
                        $map[$bot["low_bot"]]["values"][] = min($bot["values"]);
                    }
                    if (isset($bot["high_bot"])) {
                        $map[$bot["high_bot"]]["values"][] = max($bot["values"]);
                    }
                    if (isset($bot["low_out"])) {
                        $output[$bot["low_out"]] = min($bot["values"]);
                    }
                    if (isset($bot["high_out"])) {
                        $output[$bot["high_out"]] = min($bot["values"]);
                    }
                    $map[$id]["done"] = true;
                    $cont = true;
                }
            }
        }

        $id = 0;
        foreach ($map as $id => $bot) {
            if (isset($bot["values"]) && \in_array(self::REQUESTED_VALUE_1, $bot["values"], true) && \in_array(self::REQUESTED_VALUE_2, $bot["values"], true)) {
                break;
            }
        }

        return
            [
                $id,
                $output[0] * $output[1] * $output[2],
            ];
    }
}
