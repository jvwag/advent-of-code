<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2020;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2020
 */
class Day8 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // input to lines
        $lines = explode("\n", trim($this->getInput()));
        // lines to instruction array
        $code = array_map(fn($a) => explode(" ", $a), $lines);
        // convert second argument to integer
        $code = array_map(fn($a) => [$a[0], intval($a[1])], $code);

        $output1 = 0;
        // execute the code and return the accumulator
        $this->executeCode($code, $output1);

        $output2 = 0;
        // loop over the code finding jumps
        foreach ($code as $line_num => $code_line) {
            // create a copy of the code
            $code_copy = $code;
            // replace a jmp for a nop, or a nop for a jmp, or continue if this is not the case
            switch ($code_line[0]) {
                case "jmp":
                    $code_copy[$line_num][0] = "nop";
                    break;
                case "nop":
                    $code_copy[$line_num][0] = "jmp";
                    break;
                default:
                    continue 2;
            }
            // now test if the code completes (executeCode will return true)
            if ($this->executeCode($code_copy, $output2)) {
                // stop looking for jmp's
                break;
            }
        }

        // return answers
        return
            [
                $output1,
                $output2
            ];
    }

    private function executeCode(array $code, int &$acc = 0): bool
    {
        // init, p is the program pointer, acc is the accumulator register
        $p = $acc = 0;

        // loop while we are not at the end of the program
        $l = count($code);
        while ($p < $l) {

            // but break if we execute the same line twice
            if (isset($executed_code[$p])) {
                return false;
            }
            $executed_code[$p] = true;

            //
            switch ($code[$p][0]) {
                case "nop":
                    // nothing to do here
                    break;
                case "acc":
                    // on acc mnemonic increment the acc registry with the value
                    $acc += $code[$p][1];
                    break;
                case "jmp":
                    // jump to a relative point in the program
                    $p += $code[$p][1];
                    // and
                    continue 2;
            }

            // increment the program pointer
            $p++;
        }

        return true;
    }
}