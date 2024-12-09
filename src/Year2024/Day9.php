<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2024;

use jvwag\AdventOfCode\Assignment;

class Day9 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input, we keep the disk-map and not expand it,
        // that would probably take up more resources than needed
        $disk_map = array_map("intval", str_split(trim($this->getInput())));

        // the index of the last number, and init vars
        $last_file = count($disk_map) + 1;
        $position = $first_checksum = $disk_map_pointer = $last_file_untouched_block_counter = 0;

        // keep an index for the first and last block
        // the offset was trial-and-error while debugging :-/
        while ($last_file >= $disk_map_pointer + 2) {
            // two ways of processing: even indexes are the files, odd are the free space in the disk-map
            if ($disk_map_pointer % 2 === 0) {
                // loop over the number of blocks in this file
                for ($j = 0; $j < $disk_map[$disk_map_pointer]; $j++) {
                    // calculate the checksum for each block
                    $first_checksum += $position++ * ($disk_map_pointer / 2);
                }
            } else {
                // loop over the number of free blocks
                for ($j = 0; $j < $disk_map[$disk_map_pointer]; $j++) {
                    // we keep a counter of how many blocks we still need to move, if it is zero we fetch a new block
                    if ($last_file_untouched_block_counter === 0) {
                        // to target the next file at the end of the drive we decrement by two, skipping an empty space value
                        $last_file -= 2;
                        // get the initial number of blocks to move
                        $last_file_untouched_block_counter = $disk_map[$last_file];
                    }
                    // calculate the checksum for each moved block
                    $first_checksum += $position++ * ($last_file / 2);
                    // and decrement the counter for each moved block
                    $last_file_untouched_block_counter--;
                }
            }
            // go to the next item of the disk-map to process
            $disk_map_pointer++;
        }

        // when the disk map pointer reached the last file, we could still have some unprocessed blocks in the last file
        for ($j = $last_file_untouched_block_counter; $j > 0; $j--) {
            // generate checksums of these
            $first_checksum += $position++ * ($last_file / 2);
        }

        // I usually integrate part1 and part2 in one set of code, but I could not figure out how
        // to calculate it without moving data (slow?). So I settled on using some tables two tables
        // where I can describe the movement (new data for empty space, and a list of elements moved)
        $moved_to = $is_moved = [];

        // we reset the last file counter, that was used as a pointer in part1
        $last_file = count($disk_map);

        // loop over all files, from the end to the start
        for ($j = $last_file - 1; $j > 0; $j -= 2) {
            // loop over all empty spaces
            for ($k = 1; $k < $j; $k += 2) {
                // determine the free space in the block (given some data could already be moved to this block)
                $free_space = $disk_map[$k] - count($moved_to[$k] ?? []);
                // if there is free space to accommodate the file
                if ($free_space >= $disk_map[$j]) {
                    // loop over all blocks of the file
                    for ($l = 0; $l < $disk_map[$j]; $l++) {
                        // note where the file is moved, block by block
                        // we keep a per-block administration because empty space could receive more than one file
                        $moved_to[$k][] = $j / 2;
                    }
                    // also note the file is moved, so we can skip it during the checksum calculation
                    $is_moved[$j] = true;
                    // the block is moved, go to the next possible block to be moved
                    break;
                }
            }
        }

        // now we have calculated all the movement of the blocks in $moved_to and $is_moved we will loop over the
        // disk_map, expand every file to calculate the checksum
        $second_checksum = $pos = 0;
        for ($j = 0; $j < $last_file; $j++) {
            // if the index of the disk_map is even, we have a file position, or odd is a (possibly filled by now) empty space
            // we keep track of pos, which is the starting position of each file
            if (($j % 2) === 0) {
                // if the file is moved, we do not calculate the checksum at this position
                if (!isset($is_moved[$j])) {
                    // loop over all blocks of the file
                    for ($k = 0; $k < $disk_map[$j]; $k++) {
                        // calculate the checksum
                        $second_checksum += ($pos + $k) * ($j / 2);
                    }
                }
            } else {
                // process empty space: are blocks moved to this space?
                if (isset($moved_to[$j])) {
                    // loop over all blocks that are moved here
                    foreach ($moved_to[$j] as $k => $value) {
                        // calculate the checksum
                        $second_checksum += ($pos + $k) * $value;
                    }
                }
            }
            // add the length of the file, or empty space to the position counter
            $pos += $disk_map[$j] ?? 0;
        }

        // return answers
        return
            [
                $first_checksum,
                $second_checksum
            ];
    }
}