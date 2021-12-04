<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2021;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2021
 */
class Day4 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // get all lines of input
        $lines = explode("\n", trim($this->getInput()));

        // get a list of draws
        $draws = array_map("intval", explode(",", trim(array_shift($lines))));

        // skip the empty line
        array_shift($lines);

        // init boards
        $boards = [];
        $board_index = 0;

        // loop over all remaining lines
        while ($lines) {
            // parse a line and trim excess spacing
            $line = preg_replace("/\s+/", " ", trim(array_shift($lines)));

            // check if we have a full line
            if ($line) {
                // convert a line to an array of numbers in the boards array
                $boards[$board_index][] = array_map("intval", explode(" ", $line));
            } else {
                // on an empty line, we will go to the next board
                $board_index++;
            }
        }

        // init number of boards, rows
        $board_count = count($boards);
        $row_count = count($boards[0]);
        $column_count = count($boards[0][0]);

        // init assignment results
        $score_of_first_board = null;
        $score_of_last_board = null;

        // loop over all draws
        foreach ($draws as $draw) {
            // loop over all boards, rows and columns to find a drawn number
            for ($b_key = 0; $b_key < $board_count; $b_key++) {
                for ($r_key = 0; $r_key < $row_count; $r_key++) {
                    for ($c_key = 0; $c_key < $column_count; $c_key++) {
                        // check the number on a board still exists
                        if (isset($boards[$b_key][$r_key][$c_key])) {
                            // check if it is the drawn number
                            if ($boards[$b_key][$r_key][$c_key] === $draw) {
                                // if so, remove it from the board
                                unset($boards[$b_key][$r_key][$c_key]);
                            }

                            // count the number of values still present on the column of the current board
                            $items_in_this_column = array_reduce($boards[$b_key], function ($carry, $array) use ($c_key) {
                                return $carry + (int)isset($array[$c_key]);
                            });

                            // count the number of values still present on the column of the current board
                            $items_in_this_row = count($boards[$b_key][$r_key]);

                            // check for bingo: no more values on a row or column
                            if ($items_in_this_column === 0 || $items_in_this_row === 0) {
                                // is this the first card we found a bingo?
                                if ($score_of_first_board === null) {
                                    // yes! calculate the core
                                    $score_of_first_board = $this->calculate_score($boards[$b_key], $draw);
                                }

                                // do we have just one board left?
                                if (count($boards) === 1) {
                                    // yes, calculate the score
                                    $score_of_last_board = $this->calculate_score($boards[$b_key], $draw);

                                    // we can stop processing now
                                    break 4;
                                }

                                // since we had a bingo, we remove this board to never process it again
                                unset($boards[$b_key]);
                                break 2;
                            }
                        }
                    }
                }
            }
        }

        // return answers
        return
            [
                $score_of_first_board,
                $score_of_last_board
            ];
    }

    function calculate_score($board, $draw)
    {
        return $draw * array_reduce($board, function ($carry, $array) {
                return $carry + array_sum($array);
            });
    }
}