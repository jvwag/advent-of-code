<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2016;

use jvwag\AdventOfCode\Assignment;

/**
 * Class Day9
 *
 * @package jvwag\AdventOfCode\Year2016
 */
class Day9 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        $data = $this->getInput();

        for ($i = 0; ($l = \strlen($data)) && $i <= $l;) {
            if (\preg_match("/^\\((\d+)x(\d+)\\)/", \substr($data, $i), $match)) {
                [$cmd, $len, $mul] = $match;
                $base = \substr($data, $i + \strlen($cmd), (int) $len);
                $insert = \str_repeat($base, $mul);
                $data = \substr_replace($data, $insert, $i, \strlen($cmd) + $len);
                $i += \strlen($insert);
            } else {
                $i++;
            }
        }

        return
            [
                \strlen($data),
                $this->parsePart($data)
            ];
    }

    /**
     * @param $str
     *
     * @return float|int
     */
    public function parsePart($str)
    {
        $total = 0;
        while (\preg_match("/([A-Z]+)?\\((\d+)x(\d+)\\)(.*)$/", $str, $match)) {
            /** @todo remove noinspection and $tmp after fix for https://youtrack.jetbrains.com/issue/WI-34517 */
            /** @noinspection PhpUnusedLocalVariableInspection */
            [$tmp, $prepend, $len, $mul, $rest] = $match;
            $res = $this->parsePart(\substr($rest, 0, $len));
            $total += \strlen($prepend) + ($res * $mul);
            $str = \substr($str, \strlen("(" . $len . "x" . $mul . ")") + \strlen($prepend) + $len);
        }

        return \strlen($str) + $total;
    }
}
