<?php

use jvwag\AdventOfCode2016\AssignmentDownloader;

require_once(__DIR__."/../vendor/autoload.php");

$config = json_decode(file_get_contents(__DIR__."/../config/config.json"), true);
$logger = new \Monolog\Logger("day1");

$dl = new AssignmentDownloader(2016, $config["session"], $logger);
$data = $dl->getAssignmentData(3);

$valid1 = 0;
$valid2 = 0;
foreach (explode("\n", trim($data)) as $line) {
    if (preg_match("/([0-9]+)\\s+([0-9]+)\\s+([0-9]+)/", $line, $sides)) {
        if (validTriangle($sides[1], $sides[2], $sides[3])) {
            $valid1++;
        }

        $col[0][] = $sides[1];
        $col[1][] = $sides[2];
        $col[2][] = $sides[3];

        if (count($col[0]) == 3) {
            for ($x = 0; $x < 3; $x++) {
                if (validTriangle($col[$x][0], $col[$x][1], $col[$x][2])) {
                    $valid2++;
                }
            }
            $col = [];
        }
    }
}

echo $valid1 . PHP_EOL;
echo $valid2 . PHP_EOL;

function validTriangle($x, $y, $z)
{
    foreach ([[$x, $y, $z], [$x, $z, $y], [$y, $z, $x]] as $combo) {
        if ($combo[0] + $combo[1] <= $combo[2]) {
            return false;
        }
    }

    return true;
}



