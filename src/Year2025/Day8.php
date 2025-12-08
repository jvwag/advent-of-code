<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2025;

use jvwag\AdventOfCode\Assignment;

class Day8 extends Assignment
{
    private int $iterations = 1000;

    /**
     * @return array
     */
    public function run(): array
    {
        // parse all junction boxes, this will return an array: [0=>[x1,y1,z1],1=>[x2,y2,z2],...]
        $boxes = array_map(function ($line) {
            return explode(",", $line);
        }, explode("\n", trim($this->getInput())));

        // init a distance array: ["0|1"=>123.45,"0|2"=>234.34,"1|2"=>345.78,...]
        // and a circuits array [[0],[1],[2],...]
        $distances = $circuits = [];

        // loop over all junction boxes
        $c = count($boxes);
        for ($i = 0; $i < $c; $i++) {
            // fill the circuits array, now each circuit will just have one junction box
            $circuits[] = [$i];
            // loop over all other junction boxes
            for ($j = $i + 1; $j < $c; $j++) {
                // and calculate the distance... the key is a composite of the first and second junction box index
                $distances["$i|$j"] = sqrt(
                    pow($boxes[$i][0] - $boxes[$j][0], 2) +
                    pow($boxes[$i][1] - $boxes[$j][1], 2) +
                    pow($boxes[$i][2] - $boxes[$j][2], 2)
                );
            }
        }
        // sort all the distances by distance, preserving the keys
        asort($distances);

        // generate a lookup table for the distances
        $distance_keys = array_keys($distances);

        // loop
        $i = 0;
        while (true) {
            // get the id's of the two closest junction boxes
            [$a, $b] = array_map("intval", explode("|", $distance_keys[$i]));

            // lookup the circuit of the first box
            foreach ($circuits as $a_key => $circuit) {
                if (in_array($a, $circuit)) {
                    $circuit_a = $a_key;
                    break;
                }
            }

            // lookup the circuit of the second box
            foreach ($circuits as $b_key => $circuit) {
                if (in_array($b, $circuit)) {
                    $circuit_b = $b_key;
                    break;
                }
            }

            // if the boxes are not in the same circuit
            if ($circuit_a !== $circuit_b) {
                // merge the two circuits in the first circuit
                $circuits[$circuit_a] = array_merge($circuits[$circuit_a], $circuits[$circuit_b]);
                // and remove the second circuit
                unset($circuits[$circuit_b]);
            }

            // if we are at the n-th iteration (10 for unittest, 1000 for assignment)
            if ($i === $this->iterations - 1) {
                // create an array with the size of the current circuits
                foreach ($circuits as $circuit) {
                    $circuit_counts[] = count($circuit);
                }
                // sort the list
                sort($circuit_counts);
                // and take the three largest circuits and take the product of these sizes as the answer
                $output1 = array_product(array_slice($circuit_counts, -3));
            }
            // if we have only one circuit left
            if (count($circuits) === 1) {
                // calculate the product between the x values of the last processed junction box
                $output2 = $boxes[$a][0] * $boxes[$b][0];
                // and end the loop
                break;
            }
            // increment counter of iterations/position-of-junction-box-distances
            $i++;
        }

        // return answers
        return
            [
                $output1,
                $output2
            ];
    }

    public function setIterations(int $iterations): void
    {
        $this->iterations = $iterations;
    }
}