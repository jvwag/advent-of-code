<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2016;

use jvwag\AdventOfCode\Assignment;

/**
 * Class Day5
 *
 * @package jvwag\AdventOfCode\Year2016
 */
class Day5 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        $data = $this->getInput();
        $data = trim($data);

        $step = 0;
        $count1 = 0;
        $count2 = 0;
        $password1 = "";
        $password2 = "________";
        while ($count1 < 8 || $count2 < 8) {
            $md5 = md5($data . $step++);
            if (strpos($md5, "00000") === 0) {
                if ($count1 < 8) {
                    $count1++;
                    $password1 .= $md5[5];
                }
                if (is_numeric($md5[5]) && $md5[5] < 8 && $password2[$md5[5]] === "_") {
                    $count2++;
                    $password2[$md5[5]] = $md5[6];
                }
            }
        }

        return
            [
                $password1,
                $password2,
            ];
    }
}
