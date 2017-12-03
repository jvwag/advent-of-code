<?php

namespace jvwag\AdventOfCode\Year2016;

use jvwag\AdventOfCode\Assignment;

/**
 * Class Day6
 *
 * @package jvwag\AdventOfCode\Year2016
 */
class Day6 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        $data = $this->getInput();

        $lines = explode("\n", trim($data));
        $password1 = "";
        $password2 = "";
        $bucket = [];

        foreach ($lines as $line) {
            foreach (str_split($line) as $i => $c) {
                if(!isset($bucket[$i][$c])) {
                    $bucket[$i][$c] = 0;
                }
                $bucket[$i][$c]++;
            }
        }

        foreach ($bucket as $letters) {
            natsort($letters);
            reset($letters);
            $password2 .= key($letters);
            end($letters);
            $password1 .= key($letters);
        }

        return
            [
                $password1,
                $password2,
            ];
    }
}
