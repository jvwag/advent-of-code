<?php
namespace jvwag\AdventOfCode\Year2016;

use jvwag\AdventOfCode\AssignmentController;
use jvwag\AdventOfCode\AssignmentInterface;

class Day6 extends AssignmentController implements AssignmentInterface
{
    function run()
    {
        $data = $this->assignment_downloader->getAssignmentData(6);

        $lines = explode("\n", trim($data));
        $password1 = "";
        $password2 = "";
        $bucket = [];

        foreach ($lines as $line) {
            foreach (str_split($line) as $i => $c) {
                @$bucket[$i][$c]++;
            }
        }

        foreach ($bucket as $letters) {
            natsort($letters);
            reset($letters);
            $password2 .= key($letters);
            end($letters);
            $password1 .= key($letters);
        }

        echo $password1 . PHP_EOL;
        echo $password2 . PHP_EOL;
    }
}
