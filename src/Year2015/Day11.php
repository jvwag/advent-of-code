<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2015;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2015
 */
class Day11 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // trim input
        $password = trim($this->getInput());

        // find passwords
        $new_password1 = $this->newPassword($password);
        $new_password2 = $this->newPassword($new_password1);

        // return answers
        return
            [
                $new_password1,
                $new_password2
            ];
    }

    /**
     * @param string $password
     *
     * @return string
     */
    public function newPassword(string $password): string
    {
        $success = false;
        do
        {
            $password++;

            // check for strait
            $strait = false;
            for($i = 0; $i < 25; $i++) {
                if (strpos($password, chr(97 + $i) . chr(98 + $i) . chr(99 + $i)) !== false) {
                    $strait = true;
                }
            }

            // check for bad characters
            $bad_chars = false;
            foreach(["i", "o", "l"] as $char) {
                if (strpos($password, $char) !== false) {
                    $bad_chars = true;
                }
            }

            // check for to overlapping pairs of letters
            $two_overlap = 0;
            for($i = 0; $i < 26; $i++) {
                if (strpos($password, chr(97 + $i) . chr(97 + $i)) !== false) {
                    $two_overlap++;
                }
            }

            // if we ar happy with out password, we can use it
            if($strait && !$bad_chars && $two_overlap >= 2) {
                $success = true;
            }
        }
        while($success === false);

        // and return it
        return $password;
    }

}