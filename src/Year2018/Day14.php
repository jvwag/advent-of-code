<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2018;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2018
 */
class Day14 extends Assignment
{
    private const START_RECIPES = "37";
    private const START_ELF_LIST = [0, 1];

    /**
     * @return array
     */
    public function run(): array
    {
        // convert input and determine length
        $input = trim($this->getInput());
        $input_str = $input;
        $input_int = (int)$input;
        $input_len = strlen($input);

        // init outputs
        $output1 = null;
        $output2 = null;

        // init string of recipes, and its length
        $recipes = self::START_RECIPES;
        $recipes_l = strlen($recipes);

        // init the array of elf's
        $elf_list = self::START_ELF_LIST;

        // loop until we have answers for part one and two
        while (!$output1 || !$output2) {
            // if part one is not yet solved, and we are on the step matching the input
            if (!$output1 && $recipes_l > $input_int + 10) {
                // the result is the 10 chars after the input (seen as length of the recipes list)
                $output1 = substr($recipes, $input_int, 10);
            }

            // if part two is not yet solved, and we have found the input (seen as string) at the end of the list
            // and make sure to look one char wider: the previous step could have added one or two chars
            if (!$output2 && ($pos = strpos(substr($recipes, -$input_len - 1), $input_str)) !== false) {
                $output2 = $recipes_l - $input_len - 1 + $pos;
            }

            // determine the new found recipes and add them to the list, by finding the sum of the recipes at
            // the locations of the elf's
            $recipes .= array_reduce($elf_list, function ($carry, $elf) use ($recipes) {
                return $carry + $recipes[$elf];
            });
            // and, recalculate the new length once
            $recipes_l = strlen($recipes);

            // determine the new location of each elf
            foreach ($elf_list as &$elf) {
                // the current location, plus 1, plus the number of the current recipe, and looped around if needed
                $elf = ($elf + $recipes[$elf] + 1) % $recipes_l;
            }
        }

        // return answers
        return
            [
                $output1, // the 10 chars after the number of recipes (input) found
                $output2  // the number of recipes before the input is found as a sequence
            ];
    }
}