<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2024;

use jvwag\AdventOfCode\Assignment;

class Day2 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // initialize outputs
        $safe_reports = $tolerated_reports = 0;

        // loop over all input
        foreach (explode("\n", trim($this->getInput())) as $line) {
            // read a line and parse the levels
            $levels = array_map('intval', explode(" ", $line));

            // test if the levels are safe
            if ($this->testLevels($levels)) {
                $safe_reports++;
                $tolerated_reports++;
            } else {
                // if not, we will test the levels again by excluding a single level
                for ($i = 0; $i < count($levels); $i++) {
                    if ($this->testLevels($levels, $i)) {
                        // and we stop testing excluding single levels if a valid set of levels was found
                        $tolerated_reports++;
                        continue 2; // continue to parse the next set of levels
                    }
                }
            }
        }

        // return answers
        return
            [
                $safe_reports,
                $tolerated_reports
            ];
    }

    function testLevels(array $levels, int $skip = null): bool
    {
        // by argument, we can skip a single level
        if($skip !== null) {
            unset($levels[$skip]);
        }

        $prev_dir = null;
        // loop over all levels
        foreach ($levels as $level) {
            // only make decisions when we have a previous level
            if (isset($prev_level)) {
                // take the difference of the current en previous level
                $diff = $level - $prev_level;
                // if the level is not changed, or more than three: it's not valid
                if ($diff === 0 || abs($diff) > 3) {
                    return false;
                }
                // if the current level does not follow the direction we have detected: it's not valid
                if ($prev_dir !== null && ($diff <=> 0) !== $prev_dir) {
                    return false;
                }
                // store the direction (positive, or negative)
                $prev_dir = $diff <=> 0;
            }
            // store the previous value
            $prev_level = $level;
        }
        // if we reached the end of the levels: it's valid
        return true;
    }
}