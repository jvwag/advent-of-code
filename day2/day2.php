<?php

require_once("../common.php");

getAssignment(__DIR__, 2);
$data = file_get_contents("day2.txt");

// Test data, result is 1985
//$data = "ULL\nRRDDD\nLURDL\nUUUUD\n";

$numbers1 = [];
$numbers2 = [];

$num1 = 5;
$num2 = 5;
foreach (explode("\n", trim($data)) as $seq) {
    $seq = trim($seq);
    foreach (str_split($seq) as $direction) {
        $num1 = nextNumberSimple($num1, $direction);
        $num2 = nextNumberComplex($num2, $direction);
    }

    $numbers1[] = $num1;
    $numbers2[] = $num2;
}

echo join("", $numbers1) . PHP_EOL;
echo strtoupper(join("", $numbers2)) . PHP_EOL;

function nextNumberSimple($num, $direction)
{
    switch ($direction) {
        case "U":
            return $num - ($num > 3 ? 3 : 0);
        case "D":
            return $num + ($num < 7 ? 3 : 0);
        case "L":
            return $num - ((($num - 1) % 3) !== 0 ? 1 : 0);
        case "R":
            return $num + ((($num) % 3) !== 0 ? 1 : 0);
    }

    throw new \Exception();
}

function nextNumberComplex($num, $direction)
{
    $num = hexdec($num);
    switch ($direction) {
        case "U":
            if (in_array($num, [1, 2, 4, 5, 9])) {
                $num -= 0;
            } elseif (in_array($num, [6, 7, 8, 10, 11, 12])) {
                $num -= 4;
            } elseif (in_array($num, [3, 13])) {
                $num -= 2;
            } else {
                throw new \Exception("Illegal U");
            }
            break;
        case "D":
            if (in_array($num, [5, 9, 10, 12, 13])) {
                $num += 0;
            } elseif (in_array($num, [2, 3, 4, 6, 7, 8])) {
                $num += 4;
            } elseif (in_array($num, [1, 11])) {
                $num += 2;
            } else {
                throw new \Exception("Illegal D");
            }
            break;
        case "L":
            if (in_array($num, [1, 2, 5, 10, 13])) {
                $num -= 0;
            } elseif (in_array($num, [3, 4, 6, 7, 8, 9, 11, 12])) {
                $num -= 1;
            } else {
                throw new \Exception("Illegal L");
            }
            break;
        case "R":
            if (in_array($num, [1, 4, 9, 12, 13])) {
                $num += 0;
            } elseif (in_array($num, [2, 3, 5, 6, 7, 8, 10, 11])) {
                $num += 1;
            } else {
                throw new \Exception("Illegal L");
            }
            break;
        default:
            throw new \Exception("Illegal move");
    }

    return dechex($num);
}