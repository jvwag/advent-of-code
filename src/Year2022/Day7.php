<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2022;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2022
 */
class Day7 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // the root directory is an empty string, just works better :)
        $current_path = "";
        $known_directories = [""];
        $directory_sizes = ["" => 0];

        // loop over all lines, we will ony parse 'cd ..', 'cd <dir>' and file size lines
        // all other lines are not useful
        foreach (explode("\n", trim($this->getInput())) as $line) {
            if ($line === "$ cd ..") {
                // if we step down a folder, remove the last part of the directory
                $current_path = substr($current_path, 0, strrpos($current_path, "/"));
            } elseif (preg_match("/^\\$ cd ([^\/]*)$/", $line, $match)) {
                // if we find a directory change, and we do not match '/', we add the found directory to the current path
                $current_path = $current_path . "/" . $match[1];
                // save that we have found a new directory
                $known_directories[] = $current_path;
                // and initialize a counter for the data found in this directory
                $directory_sizes[$current_path] = 0;
            } elseif (preg_match("/(\d+) (.*)$/", $line, $match)) {
                // if we find a file with a size, we loop over all know directories to see of the full patch of the file
                // matches a know directory, to add the file size to the counter for that directory 
                foreach ($known_directories as $known_directory) {
                    if (str_starts_with($current_path . "/" . $match[2], $known_directory . "/")) {
                        $directory_sizes[$known_directory] += intval($match[1]);
                    }
                }
            }
        }

        // loop over all directory_sizes to find entries smaller than 100k, and sum those values
        $sum_of_all_directories_with_a_size_no_greater_then_100k =
            array_sum(
                array_filter($directory_sizes, function ($x) {
                    return $x < 100000;
                })
            );

        // calculate free space based on the root directory size
        $free_space = 70000000 - $directory_sizes[""];
        
        // sort the directory sizes
        asort($directory_sizes, SORT_NUMERIC);

        // and loop over all directory sizes to find the first (so the smallest) value to gather enough free space
        $size_of_smallest_directory_to_be_deleted_to_acquire_enough_free_space = null;
        foreach ($directory_sizes as $total) {
            if ($free_space + $total > 30000000) {
                $size_of_smallest_directory_to_be_deleted_to_acquire_enough_free_space = $total;
                break;
            }
        }

        // return answers
        return
            [
                $sum_of_all_directories_with_a_size_no_greater_then_100k,
                $size_of_smallest_directory_to_be_deleted_to_acquire_enough_free_space
            ];
    }
}