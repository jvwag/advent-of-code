<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2015;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2015
 */
class Day8 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $lines = array_map("trim", explode("\n", trim($this->getInput())));

        // init vars
        $e = "";
        $total = 0;
        $chars1 = 0;
        $chars2 = 0;

        // loop over lines
        foreach ($lines as $line) {
            /**
             * CAUTION, DEAD STOP AHEAD
             * - comment this line if you are really sure you want this!
             * - https://stackoverflow.com/questions/951373/when-is-eval-evil-in-php
             */
            assert(false, "The solution of Day 8 in 2015 is disabled because it uses eval() and possibly with remote data" . PHP_EOL);

            /**
             * WARNING, BIG SECURITY HOLE
             */

            /** @noinspection PhpUnreachableStatementInspection */
            eval("\$e = $line;");

            $total += strlen($line);
            $chars1 += strlen($e);
            $chars2 += strlen("\"" . str_replace(["\\", "\""], ["\\\\", "\\\""], $line) . "\"");
        }

        // init output
        $output1 = $total - $chars1;
        $output2 = $chars2 - $total;

        // return answers
        return
            [
                $output1,
                $output2,
            ];
    }
}