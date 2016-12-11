<?php

use jvwag\AdventOfCode2016\AssignmentDownloader;

require_once(__DIR__."/../vendor/autoload.php");

$config = json_decode(file_get_contents(__DIR__."/../config/config.json"), true);
$logger = new \Monolog\Logger("day1");

$dl = new AssignmentDownloader(2016, $config["session"], $logger);
$data = $dl->getAssignmentData(1);

$x = 0;
$y = 0;
$d = 0;
$first_crossing = false;
$visited_blocks = [];

// Parse all locations
preg_match_all("/([LR])([0-9]+)/", $data, $match, PREG_SET_ORDER);
foreach ($match as list($action, $direction, $distance)) {

    // Determine new direction
    $d = ($d + ($direction == 'L' ? -90 : 90) + 360) % 360;

    // Single increments to determine the first crossing
    for ($i = 0; $i < $distance; $i++) {
        // Determine new location in grid
        $x += $d == 270 ? -1 : ($d == 90 ? 1 : 0);
        $y += $d == 0 ? -1 : ($d == 180 ? 1 : 0);

        // See if block is already visited
        if (!$first_crossing && isset($visited_blocks[$x][$y])) {
            printf("first pass at %d, %d".PHP_EOL, $x, $y);
            $first_crossing = [$x, $y];
        }

        // Store location of visited block
        $visited_blocks[$x][$y] = true;
    }

    $logger->debug(sprintf("action %-5s | direction: %s | distance: %-3d | x: %-3d | y: %-3d | d: %-3d".PHP_EOL, $action, $direction, $distance, $x, $y, $d));
}

echo (abs($x) + abs($y)) . PHP_EOL;
echo (abs($first_crossing[0]) + abs($first_crossing[1])) . PHP_EOL;