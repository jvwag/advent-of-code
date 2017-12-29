<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2015;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2015
 */
class Day14 extends Assignment
{
    private const SECONDS = 2503;

    /**
     * @return array
     */
    public function run(): array
    {
        return $this->calculate();
    }

    /**
     * @param int $time
     *
     * @return array
     */
    public function calculate(int $time = self::SECONDS): array
    {
        // get lines
        $lines = \explode("\n", \trim($this->getInput()));

        // convert input to data
        $data = [];
        foreach ($lines as $line) {
            if (preg_match("|^(.+) can fly (\d+) km/s for (\d+) seconds, but then must rest for (\d+) seconds.$|", $line, $match)) {
                $data[] = ["name" => $match[1], "speed" => $match[2], "fly_time" => $match[3], "rest_time" => $match[4], "flying" => $match[3], "resting" => 0, "distance" => 0, "score" => 0];
            }
        }

        // init vars
        $c = \count($data);
        $distances = [];
        $scores = [];

        // try for a fixed amount of settings
        for ($i = 1; $i <= $time; $i++) {
            // loop over the reindeer and track their progress
            $distances = [];
            for ($j = 0; $j < $c; $j++) {
                if ($data[$j]["flying"] > 0) {
                    $data[$j]["distance"] += $data[$j]["speed"];
                    $data[$j]["flying"]--;

                    if (!$data[$j]["flying"]) {
                        $data[$j]["resting"] = $data[$j]["rest_time"];
                    }
                } elseif ($data[$j]["resting"] > 0) {
                    $data[$j]["resting"]--;

                    if ($data[$j]["resting"] === 0) {
                        $data[$j]["flying"] = $data[$j]["fly_time"];
                    }
                }

                $distances[] = $data[$j]["distance"];
            }

            // get the max distance
            $max_distance = max($distances);

            // give reindeer scores based on their distance
            for ($j = 0; $j < $c; $j++) {
                if ($data[$j]["distance"] === $max_distance) {
                    $data[$j]["score"]++;
                }

                $scores[] = $data[$j]["score"];
            }
        }

        // return answers
        return
            [
                max($distances),
                max($scores),
            ];
    }
}