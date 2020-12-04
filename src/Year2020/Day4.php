<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2020;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year202
 */
class Day4 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        $c = 0;
        $list = [0 => []];
        foreach (explode("\n", trim($this->getInput())) as $line) {
            if ($line === "") {
                $list[++$c] = [];
            }
            if (preg_match_all("/\s?([^:]+):([^\s]+)/", $line, $match)) {
                $list[$c] += array_merge($list[$c], array_combine($match[1], $match[2]));
            }
        }

        $list = array_filter($list, fn($p) => isset($p["byr"], $p["iyr"], $p["eyr"], $p["hgt"], $p["hcl"], $p["ecl"], $p["pid"]));
        $output1 = count($list);

        $match = [];
        $list = array_filter($list, fn($p) => preg_match("/^[0-9]{4}$/", $p["byr"]) && $p["byr"] >= 1920 && $p["byr"] <= 2002);
        $list = array_filter($list, fn($p) => preg_match("/^[0-9]{4}$/", $p["iyr"]) && $p["iyr"] >= 2010 && $p["iyr"] <= 2020);
        $list = array_filter($list, fn($p) => preg_match("/^[0-9]{4}$/", $p["eyr"]) && $p["eyr"] >= 2020 && $p["eyr"] <= 2030);
        $list = array_filter($list, fn($p) => preg_match("/\d+(cm|in)$/", $p["hgt"]));
        $list = array_filter($list, fn($p) => preg_match("/in$/", $p["hgt"]) || preg_match("/(\d+)cm$/", $p["hgt"], $match) && intval($match[1]) >= 150 && intval($match[1]) <= 193);
        $list = array_filter($list, fn($p) => preg_match("/cm$/", $p["hgt"]) || preg_match("/(\d+)in$/", $p["hgt"], $match) && intval($match[1]) >= 59 && intval($match[1]) <= 76);
        $list = array_filter($list, fn($p) => preg_match("/^#[0-9a-f]{6}$/", $p["hcl"]));
        $list = array_filter($list, fn($p) => in_array($p["ecl"], ["amb", "blu", "brn", "gry", "grn","hzl","oth"], true));
        $list = array_filter($list, fn($p) => preg_match("/^[0-9]{9}$/", $p["pid"]));
        $output2 = count($list);

        // return answers
        return
            [
                $output1,
                $output2
            ];
    }
}