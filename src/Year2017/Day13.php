<?php

namespace jvwag\AdventOfCode\Year2017;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2017
 */
class Day13 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        $firewall = [];

        // convert input to a firewall array with layer as key and the range as value
        $lines = explode("\n", trim($this->getInput()));
        foreach ($lines as $line) {
            [$layer, $range] = array_map("trim", explode(":", trim($line)));
            $firewall[$layer] = $range;
        }

        // for part 1 we look for a severity
        $severity = 0;
        // so we loop over all rules and see were we hit the firewall
        foreach ($firewall as $layer => $range) {
            // we hit the firewall if the modulus of two times the range minus one, is zero
            if ($layer % ((2 * ($range - 1))) === 0) {
                // the severity number is the sum of layer times the range for all hits
                $severity += $layer * $range;
            }
        }

        // for part 2 we look for the delay of a firewall traversal with no hits
        $delay = 0;
        // so we loop until we found the perfect delay
        while (true) {
            // loop over all rules
            foreach ($firewall as $layer => $range) {
                // and see if we hit any firewall on a specific delay
                if (($delay + $layer) % ((2 * ($range - 1))) === 0) {
                    // we have hit the firewall, up the delay and start over from the top
                    $delay++;
                    continue 2;
                }
            }
            // if we came this far: we found a delay which did not hit any firewall rule
            break;
        }

        // return answers
        return
            [
                $severity, // the severity of hitting the firewall without a delay
                $delay, // the delay where no firewall rule triggers
            ];
    }
}