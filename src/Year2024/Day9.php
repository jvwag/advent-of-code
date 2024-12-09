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
        // convert input
        $disk_map = array_map("intval", str_split(trim($this->getInput())));

        // the index of the last number, and init vars
        $last_file = count($disk_map) + 1;
        $position = $first_checksum = $disk_map_pointer = $last_file_untouched_block_counter = 0;

        // keep an index for the first and last block
        while ($last_file >= $disk_map_pointer + 2) {
            // two ways of processing: even indexes are the files, odd are the free space
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

        // return answers
        return
            [
                $first_checksum,
                null
            ];
    }
}