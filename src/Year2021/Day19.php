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

        $beacon_count = 0;
        $beacons = $vectors = [];
        foreach ($scanners as $scanner_id => $scanner_beacons) {
            $scanner_beacons = explode("\n", $scanner_beacons);
            array_shift($scanner_beacons);

            foreach ($scanner_beacons as $scanner_beacon) {
                if (preg_match("/^(-?\d+),(-?\d+),(-?\d+)$/", $scanner_beacon, $match)) {
                    $beacon_count++;
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
        $overlap = $relative = [];
        for ($a = 0; $a < $c - 1; $a++) {
            for ($b = $a + 1; $b < $c; $b++) {
                if ($vectors[$a][3] === $vectors[$b][3]) {
                    $overlap[$vectors[$a][0]][] = $vectors[$a][1];
                    $overlap[$vectors[$a][0]][] = $vectors[$a][2];
                    $relative[] = [$vectors[$a][0], $vectors[$b][0], $vectors[$a][1], $vectors[$a][2], $vectors[$b][1], $vectors[$b][2]];
                    $relative[] = [$vectors[$b][0], $vectors[$a][0], $vectors[$b][1], $vectors[$b][2], $vectors[$a][1], $vectors[$a][2]];
                }
            }
        }

        $overlap = array_map("array_unique", $overlap);
        $overlap = array_map("count", $overlap);

        $output1 = $beacon_count - array_sum($overlap);

        $scanner_pos1 = $scanner_pos2 = [];
        foreach ($relative as [$scanner_a, $scanner_b, $beacon0a, $beacon0b, $beacon1a, $beacon1b]) {

            $beacon0a = $beacons[$scanner_a][$beacon0a];
            $beacon0b = $beacons[$scanner_a][$beacon0b];
            $beacon1a = $beacons[$scanner_b][$beacon1a];
            $beacon1b = $beacons[$scanner_b][$beacon1b];

//            echo join(",", $beacon0a)." - ".join(",", $beacon0b)." | ".join(",", $beacon1a)." - ".join(",", $beacon1b).PHP_EOL;
//            foreach ([[0, 1, 2], [1, 2, 0], [2, 0, 1]] as $rotation) {
            foreach ([[0, 1, 2], [0, 2, 1], [1, 0, 2], [1, 2, 0], [2, 0, 1], [2, 1, 0]] as $rotation) {
                foreach ([[1, 1, 1], [1, 1, -1], [1, -1, 1], [1, -1, -1], [-1, 1, 1], [-1, 1, -1], [-1, -1, 1], [-1, -1, -1]] as $facing) {

                    $test_beacon1a = [$beacon1a[$rotation[0]] * $facing[0], $beacon1a[$rotation[1]] * $facing[1], $beacon1a[$rotation[2]] * $facing[2]];
                    $test_beacon1b = [$beacon1b[$rotation[0]] * $facing[0], $beacon1b[$rotation[1]] * $facing[1], $beacon1b[$rotation[2]] * $facing[2]];

                    if (
                        $test_beacon1a[0] - $test_beacon1b[0] === $beacon0a[0] - $beacon0b[0] &&
                        $test_beacon1a[1] - $test_beacon1b[1] === $beacon0a[1] - $beacon0b[1] &&
                        $test_beacon1a[2] - $test_beacon1b[2] === $beacon0a[2] - $beacon0b[2]) {

//                        $pos = [
//                            ($test_beacon1a[0] - $beacon0a[0]) * $facing,
//                            ($test_beacon1a[1] - $beacon0a[1]) * $facing,
//                            ($test_beacon1a[2] - $beacon0a[2]) * $facing
//                        ];

                        //echo "scanner_a: ".$scanner_a.", scanner_b " . $scanner_b . ": " . join(",", $pos) . PHP_EOL;

                        $scanner_pos1[$scanner_a . "/" . $scanner_b][] = join(",", [
                            ($test_beacon1b[0] - $beacon0b[0]) * $facing[0],
                            ($test_beacon1b[1] - $beacon0b[1]) * $facing[1],
                            ($test_beacon1b[2] - $beacon0b[2]) * $facing[2]
                        ]);
//                        $scanner_pos2[$scanner_b . "/" . $scanner_a][] = join(",", [
//                            ($test_beacon1a[0] - $beacon0a[0]) * $facing[0] * -1,
//                            ($test_beacon1a[1] - $beacon0a[1]) * $facing[1] * -1,
//                            ($test_beacon1a[2] - $beacon0a[2]) * $facing[2] * -1
//                        ]);
                        break 2;
                    }

                }
            }
        }

        $new_list = [];
        foreach ($scanner_pos1 as $combo => $poslist) {
            $clist = array_count_values($poslist);
            //var_dump($clist);

            $value = array_map("intval", explode(",", key($clist)));
            $first = reset($clist);
            if ($first > 24) {
                $combo = explode("/", $combo);
                $new_list[$combo[0]][$combo[1]] = $value;
            }
        }
//
//        foreach ($scanner_pos2 as $combo => $poslist) {
//            $clist = array_count_values($poslist);
//            //var_dump($clist);
//
//            $value = array_map("intval", explode(",", key($clist)));
//            $first = reset($clist);
//            if ($first > 10) {
//                $combo = explode("/", $combo);
//                $new_list[$combo[0]][$combo[1]] = $value;
//            }
//        }


        $q = 0;
        $last_pos = [];
        foreach ($scanners as $key => $tmp) {
            $last_pos[$key] = [0, 0, 0];
            if ($key !== 0) {
                $found_key = $key;
                while ($found_key !== 0) {
                    $found_pos = reset($new_list[$found_key]);
                    //echo "looking for $key, via $found_key (" . join(",", $last_pos[$key]) . " + " . join(",", $found_pos) . " = ";
                    if ($last_pos[$key][0] === 0) {
                        $last_pos[$key][0] = $found_pos[0];
                    } else {
                        $last_pos[$key][0] -= $found_pos[0];
                    }
                    if ($last_pos[$key][1] === 0) {
                        $last_pos[$key][1] = $found_pos[1];
                    } else {
                        $last_pos[$key][1] -= $found_pos[1];
                    }
                    if ($last_pos[$key][2] === 0) {
                        $last_pos[$key][2] = $found_pos[2];
                    } else {
                        $last_pos[$key][2] -= $found_pos[2];
                    }
                    //echo join(",", $last_pos[$key]) . ")" . PHP_EOL;
                    $found_key = key($new_list[$found_key]);
                    if ($q++ > 100)
                        die();
                }
            }

        }

        $ans = [[0, 0, 0], [68, -1246, -43], [1105, -1205, 1229], [-92, -2380, -20], [-20, -1133, 1061]];

        foreach ($last_pos as $id => $vals) {
            echo "| " . $id . ": " . join(",", $vals) . "\n     " . join(",", $ans[$id]) . PHP_EOL;
        }


        $output2 = null;

        // return answers
        return
            [
                $output1,
                $output2
            ];
    }
}