<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2020;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year202
 */
class Day1b extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input to a sorted list of integers
        $input = $this->getInput();
        $numbers = explode("\n", trim($input));
        $numbers = array_map("intval", $numbers);
        $numbers = array_combine($numbers, $numbers);

        // return answers
        return
            [
                $this->run1($numbers, 2020),
                $this->run2($numbers, 2020)
            ];
    }

    /**
     * Give the product of two found numbers in a list of integers,
     * where the sum of the two integers equals the target number.
     *
     * @param int[] $ints List of integers
     * @param int $target Target integers
     * @return int Product of found integers
     */
    public function run1(array $ints, int $target): ?int
    {
        return array_product(
            array_filter(
                $ints,
                fn($v) => isset(
                    $ints[$target - $v]
                )
            )
        );
    }

    /**
     * Give the product of three found numbers in a list of integers,
     * where the sum of the three integers equals the target number.
     *
     * @param int[] $ints List of integers
     * @param int $target Target integers
     * @return int Product of found integers
     */
    public function run2(array $ints, int $target): ?int
    {
        return array_product(
            array_filter(
                $ints,
                fn($v) => isset(
                    $ints[$target - array_sum(
                        array_filter(
                            $ints,
                            fn($w) => isset(
                                $ints[$target - $v - $w]
                            )
                        )
                    )]
                )
            )
        );
    }
}