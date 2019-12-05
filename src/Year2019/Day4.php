<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2019;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2019
 */
class Day4 extends Assignment
{
    private const REGEX_DOUBLES = "/(00|11|22|33|44|55|66|77|88|99)/";
    private const REGEX_DECR = "/(98|97|96|95|94|93|92|91|90|87|86|85|84|83|82|81|80|76|75|74|73|72|71|70|65|64|63|62|61|60|54|53|52|51|50|43|42|41|40|32|31|30|21|20|10)/";

    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $passwords = array_map("strval", range(...explode("-", trim($this->getInput()))));

        // filter for answer 1
        $passwords = $this->filter1($passwords);
        $output1 = count($passwords);

        // filter for answer 2
        $passwords = $this->filter2($passwords);
        $output2 = count($passwords);

        // return answers
        return
            [
                $output1,
                $output2
            ];
    }

    public function filter1(array $arr): array
    {
        // only use values with at least two consecutive digits
        $arr = array_filter($arr, static function ($val) {
            return preg_match(self::REGEX_DOUBLES, $val);
        });

        // only use values with incrementing order
        $arr = array_filter($arr, static function ($val) {
            return !preg_match(self::REGEX_DECR, $val);
        });

        return $arr;
    }

    public function filter2(array $arr): array
    {
        // now only use values with exactly 2 consecutive values
        $arr = array_filter($arr, static function ($val) {
            return in_array(2, count_chars($val), true);
        });
        return $arr;
    }
}