<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2021;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2021
 */
class Day10 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // init matching patterns and scores
        $correct_patterns = ["()", "[]", "{}", "<>"];
        $incomplete_characters_with_points = ["(" => 1, "[" => 2, "{" => 3, "<" => 4];
        $corrupt_patterns_with_points = [
            "[)" => 3, "{)" => 3, "<)" => 3,
            "(]" => 57, "{]" => 57, "<]" => 57,
            "(}" => 1197, "[}" => 1197, "<}" => 1197,
            "(>" => 25137, "[>" => 25137, "{>" => 25137
        ];

        // init output values and temporary arrays
        $illegal_character_score = 0;
        $incomplete_line_scores = [];

        // loop over each line
        foreach(explode("\n", trim($this->getInput())) as $line) {
            $prev_length = null;
            //process the line
            while(true) {
                // if the length of the line was smaller than the previous iteration, than we can continue to
                // find and remove correct patterns, or to find an illegal pattern
                if($prev_length !== ($length = strlen($line))) {
                    $prev_length = $length;

                    // remove all correct patterns
                    $line = str_replace($correct_patterns, "", $line);

                    // loop over all corrupt patterns
                    foreach($corrupt_patterns_with_points as $corrupted_chunk_pattern => $points) {
                        // if a corrupt pattern is matched
                        if(strpos($line, $corrupted_chunk_pattern) !== false) {
                            // add the points to the score
                            $illegal_character_score += $points;
                            // and stop processing this line
                            break 2;
                        }
                    }
                } else {
                    // in the case the line did not get shorter for matching legal and illegal patterns
                    // we are in the second part of the assignment: completing the pattern
                    $incomplete_characters_score = 0;

                    // the pattern that need to be completed is always the reverse of the current pattern left
                    foreach(array_reverse(str_split($line)) as $char) {
                        // first we need to multiply the current score by 5
                        $incomplete_characters_score *= 5;
                        // and add points of the missing character to the score
                        $incomplete_characters_score += $incomplete_characters_with_points[$char];
                    }
                    // we will keep a list of scores
                    $incomplete_line_scores[] = $incomplete_characters_score;

                    // and end the processing loop after calculating
                    break;
                }
            }
        }

        // the score list should be sorted, and the median score should be used
        sort($incomplete_line_scores);
        $incomplete_line_score = $incomplete_line_scores[floor(count($incomplete_line_scores) / 2)];

        // return answers
        return
            [
                $illegal_character_score,
                $incomplete_line_score
            ];
    }
}