<?php
namespace jvwag\AdventOfCode\Year2016;

use jvwag\AdventOfCode\AssignmentController;
use jvwag\AdventOfCode\AssignmentInterface;

class Day5 extends AssignmentController implements AssignmentInterface
{
    function run()
    {
        $data = $this->assignment_downloader->getAssignmentData(5);

        $step = 0;
        $count1 = 0;
        $count2 = 0;
        $password1 = "";
        $password2 = "________";
        while($count1 < 8 || $count2 < 8) {
            $md5 = md5($data.$step++);
            if(substr($md5, 0, 5) === "00000") {
                if($count1 < 8) {
                    $count1++;
                    $password1 .= $md5[5];
                }
                if(is_numeric($md5[5]) && $md5[5] < 8 && $password2[$md5[5]] === "_") {
                    $count2++;
                    $password2[$md5[5]] = $md5[6];
                }
            }
        }
        echo $password1.PHP_EOL;
        echo $password2.PHP_EOL;
    }
}
