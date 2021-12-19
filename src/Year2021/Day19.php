<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2021;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2021
 */
class Day19 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $scanners = explode("\n\n", trim($this->getInput()));

        $beacons = $vectors = $count_per_scanner = [];
        foreach ($scanners as $scanner_id => $scanner_beacons) {
            $scanner_beacons = explode("\n", $scanner_beacons);
            array_shift($scanner_beacons);
            $count_per_scanner[$scanner_id] = count($scanner_beacons);
            foreach ($scanner_beacons as $scanner_beacon) {
                if (preg_match("/^(-?\d+),(-?\d+),(-?\d+)$/", $scanner_beacon, $match)) {
                    [, $x, $y, $z] = array_map("intval", $match);
                    $beacons[$scanner_id][] = [$x, $y, $z];
                }
            }

            $c = count($beacons[$scanner_id]);
            for ($a = 0; $a < $c - 1; $a++) {
                for ($b = $a + 1; $b < $c; $b++) {
                    $distances =
                        [
                            abs($beacons[$scanner_id][$a][0] - $beacons[$scanner_id][$b][0]),
                            abs($beacons[$scanner_id][$a][1] - $beacons[$scanner_id][$b][1]),
                            abs($beacons[$scanner_id][$a][2] - $beacons[$scanner_id][$b][2])
                        ];
                    sort($distances);
                    $vectors[] = [$scanner_id, $a, $b, $distances];
                }
            }
        }

        $c = count($vectors);
        $overlap = [];
        for ($a = 0; $a < $c - 1; $a++) {
            for ($b = $a + 1; $b < $c; $b++) {
                if ($vectors[$a][3] === $vectors[$b][3]) {
                    $overlap[$vectors[$a][0]][] = $vectors[$a][1];
                    $overlap[$vectors[$a][0]][] = $vectors[$a][2];
                }
            }
        }

        $overlap = array_map("array_unique", $overlap);
        $overlap = array_map("count", $overlap);

        $output1 = array_sum($count_per_scanner) - array_sum($overlap);
        $output2 = null;

        // return answers
        return
            [
                $output1,
                $output2
            ];
    }
}