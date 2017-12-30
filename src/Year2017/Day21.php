<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2017;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2017
 */
class Day21 extends Assignment
{
    public const BASE = ".#./..#/###";
    private const SEP = "/";
    private const EMPTY_CHAR = ".";
    private const FILLED_CHAR = "#";


    /**
     * @return array
     */
    public function run(): array
    {
        // convert input to rules
        $rules = $this->parseRules($this->getInput());

        // return answers
        return
            [
                $this->run1(self::BASE, $rules, 5),
                $this->run1(self::BASE, $rules, 18),
            ];
    }

    /**
     * Upscale the image.
     *
     * @param string $image Image given as a string with '.' and '#' and a new row separated with a '/'
     * @param string[] $rules Array of rules where a image string get upscaled to a slightly bigger image
     * @param int $iterations Number of times to iterate
     * @return int Number of '#' pixels in the image after iterations
     */
    public function run1($image, $rules, $iterations): int
    {
        // loop for the given number of iterations
        for ($x = 0; $x < $iterations; $x++) {
            // split the image into chunks, apply the rules and join the image again
            $image = $this->join(
                \array_map(
                    function ($x) use ($rules) {
                        return $rules[$x];
                    },
                    $this->split($image)
                )
            );
        }

        // count the number of '#' pixels
        return \substr_count($image, self::FILLED_CHAR);
    }

    /**
     * Generate rule list.
     *
     * @param string $input List of rules separated by a newline
     * @return string[] Array of rules and all permutations by rotating and flipping the rules
     */
    public function parseRules($input): array
    {
        $rules = [];
        // loop over every line
        foreach (\explode("\n", \trim($input)) as $line) {
            // extract the rule and the result
            [$rule, $result] = \explode(" => ", \trim($line));

            // loop over 4x rotation and flipping (the forth is also the begin state)
            for ($x = 0; $x < 4; $x++) {
                $rules[$rule = $this->rotate($rule)] = $result;
                $rules[$this->flip($rule)] = $result;
            }
        }

        // return the rules
        return $rules;
    }

    /**
     * Rotate matrix for characters with '/' as a new row separator for 90 degrees.
     *
     * This function does more than required for this assignment: it can also rotate non-symmetric matrices.
     *
     * @param string $input Matrix of characters with a '/' for a new row
     * @return string Rotated matrix of chars 90 degrees
     */
    public function rotate($input): string
    {
        // determine height and width based on the number of '\' or the position of the first '\'
        $height = \substr_count($input, self::SEP) + 1;
        $width = \strpos($input, self::SEP);

        // generate a base output with all '/' separators and '.' empty spaces on the right place
        $output = \implode(self::SEP, \array_fill(0, $width, \str_repeat(self::EMPTY_CHAR, $height)));

        // loop over all x and y points
        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                // and translate very point to a new place rotated 90 degrees
                $output[$x * ($height + 1) + $y] = $input[($height - $y - 1) * ($width + 1) + $x];
            }
        }

        // return the output
        return $output;
    }

    /**
     * Flip matrix for characters with '/' as a new row separator horizontally.
     *
     * This function does more than required for this assignment: it can also flip non-symmetric matrices.
     *
     * @param string $input Matrix of characters with a '/' for a new row
     * @return string Horizontal flipped matrix of chars
     */
    public function flip($input): string
    {
        // determine height and width based on the number of '\' or the position of the first '\'
        $height = \substr_count($input, self::SEP) + 1;
        $width = \strpos($input, self::SEP);

        // generate a base output with all '/' separators and '.' empty spaces on the right place
        $output = \implode(self::SEP, \array_fill(0, $height, \str_repeat(self::EMPTY_CHAR, $width)));

        // loop over all x and y points
        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                // and translate very point to a new place flipped over the horizontal center of the matrix
                $output[$y * ($width + 1) + $x] = $input[($height - $y - 1) * ($width + 1) + $x];
            }
        }

        // return the output
        return $output;
    }

    /**
     * Splits a matrix into chunks of 2x2 or 3x3 matrices.
     *
     * @param string $input Matrix of characters with a '/' for a new row
     * @return string[] Array of matrices of characters with a '/' for a new row
     */
    public function split($input): array
    {
        // init output array
        $output = [];

        // determine width and size of chunks
        $width = \strpos($input, self::SEP);
        $size = $width % 2 === 0 ? 2 : 3;

        // loop over all chunks (x and y)
        for ($y = 0; $y < $width; $y += $size) {
            for ($x = 0; $x < $width; $x += $size) {
                $chunk = [];
                // loop over all elements in a chunk (x2 and y2)
                for ($y2 = 0; $y2 < $size; $y2++) {
                    $chunk_row = "";
                    for ($x2 = 0; $x2 < $size; $x2++) {
                        // rearrange a new chuck by writing a new chunk row
                        $chunk_row .= $input[($y + $y2) * ($width + 1) + ($x + $x2)];
                    }
                    // combine the chunk_line line into an chunk array
                    $chunk[] = $chunk_row;

                }
                // and separate chunk array with '/' separators, filling it into the output array
                $output[] = \implode(self::SEP, $chunk);
            }
        }

        // return the output
        return $output;
    }

    /**
     * Joins an array of matrix chunks into a full matrix
     *
     * @param string[] $input Array of matrices of characters with a '/' for a new row
     * @return string Matrix of characters with a '/' for a new row
     */
    public function join($input): string
    {
        // determine width and size of chunks
        $count = (int)\sqrt(\count($input));
        $size = \strpos($input[0], self::SEP);

        // generate a base output with all '/' separators and '.' empty spaces on the right place
        $output = \implode(self::SEP, \array_fill(0, $count * $size, \str_repeat(self::EMPTY_CHAR, $count * $size)));

        // loop over all chunks (x and y)
        for ($y = 0; $y < $count; $y++) {
            for ($x = 0; $x < $count; $x++) {
                // loop over all elements in a chunk (x2 and y2)
                for ($y2 = 0; $y2 < $size; $y2++) {
                    for ($x2 = 0; $x2 < $size; $x2++) {
                        // place all elements of a chunk in the correct position of the output matrix
                        $output[(($y * $size) + $y2) * ($count * $size + 1) + (($x * $size) + $x2)] = $input[($y * $count) + $x][$y2 * ($size + 1) + $x2];
                    }
                }
            }
        }

        // return the output
        return $output;
    }
}