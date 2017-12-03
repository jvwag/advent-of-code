<?php

namespace jvwag\AdventOfCode\Year2015;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2015
 */
class Day7 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $lines = \explode("\n", \trim($this->getInput()));

        // generate rules from input
        $rules = [];
        foreach ($lines as $line) {
            if (\preg_match("|^(([0-9a-z]+ )?([A-Z]+) )?([0-9a-z]+) -> ([a-z]+)$|", $line, $match)) {
                $rules[$match[5]] = [trim($match[2]), $match[3], $match[4]];
            }
        }


        // use rules to determine signal a
        $search1 = $rules;
        $output1 = $this->lookup($search1, "a");

        // take the previous answer and hard wire it to signal b
        $search2 = $rules;
        $search2["b"] = $output1;
        $output2 = $this->lookup($search2, "a");

        // return answers
        return
            [
                $output1,
                $output2,
            ];
    }

    /**
     * Traverse ruleset and return answer for given wire
     *
     * @param $circuit
     * @param $wire
     *
     * @return bool|int
     */
    private function lookup(&$circuit, $wire)
    {
        // if its not a wire but a value, return it
        if (is_numeric($wire)) {
            return $wire;
        }

        // if we have a link to a value, return it
        if (is_numeric($circuit[$wire])) {
            return $circuit[$wire];
        }

        // loop over commands and recursive lookup that wire
        $r = null;
        if ($circuit[$wire][1] === "") {
            $r = $this->lookup($circuit, $circuit[$wire][2]);
        } elseif ($circuit[$wire][1] === "OR") {
            $r = $this->lookup($circuit, $circuit[$wire][0]) | $this->lookup($circuit, $circuit[$wire][2]);
        } elseif ($circuit[$wire][1] === "AND") {
            $r = $this->lookup($circuit, $circuit[$wire][0]) & $this->lookup($circuit, $circuit[$wire][2]);
        } elseif ($circuit[$wire][1] === "LSHIFT") {
            $r = $this->lookup($circuit, $circuit[$wire][0]) << $this->lookup($circuit, $circuit[$wire][2]);
        } elseif ($circuit[$wire][1] === "RSHIFT") {
            $r = $this->lookup($circuit, $circuit[$wire][0]) >> $this->lookup($circuit, $circuit[$wire][2]);
        } elseif ($circuit[$wire][1] === "NOT") {
            $r = ~$this->lookup($circuit, $circuit[$wire][2]);
        }

        // check to see if we have made a lookup
        if ($r !== null) {
            return $circuit[$wire] = $r;
        }

        return \assert(false, "invalid input");
    }

}