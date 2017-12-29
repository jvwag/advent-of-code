<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2017;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2017
 */
class Day16 extends Assignment
{
    private const PASSES = 10000000;

    /**
     * @return array
     */
    public function run(): array
    {
        // get input
        $input = $this->getInput();

        // generate the circular buffer string from a-p
        $buffer = implode("", range("a", "p"));

        // return answers
        return
            [
                $this->pass($buffer, $input), // one pass
                $this->pass($buffer, $input, self::PASSES), // 10 million passes
            ];
    }

    /**
     * Reorder a circular buffer given the input and the amount of passes to process the input
     *
     * @param string $buffer Circular buffer with unique bytes
     * @param string $input Comma separated list of commands
     * @param int $passes Number of passes
     * @return string Ordered circular buffer given the commands
     */
    public function pass($buffer, $input, $passes = 1): string
    {
        // convert input
        $commands = explode(",", trim($input));

        $base = $buffer;
        // loop for given amount of passes
        for ($x = 1; $x <= $passes; $x++) {
            // loop over all commands
            foreach ($commands as $command) {
                // parse command and determine type and arguments
                if (preg_match("#^(s|x|p)([^/]+)(/(.*))?$#", $command, $match)) {
                    /** @noinspection PhpUnusedLocalVariableInspection */
                    [$tmp, $type, $arg1] = $match;
                    $arg2 = $match[4] ?? null;

                    switch ($type) {
                        // rotate all programs in circular buffer for argument number of steps
                        case "s":
                            $buffer = substr($buffer, -$arg1) . substr($buffer, 0, -$arg1);
                            break;

                        // switch position of two programs by position in circular buffer
                        case "x":
                            $tmp = $buffer[(int)$arg1];
                            $buffer[(int)$arg1] = $buffer{(int)$arg2};
                            $buffer[(int)$arg2] = $tmp;
                            break;
                        // switch position of two programs by name in circular buffer
                        case "p":
                            $pos1 = strpos($buffer, $arg1);
                            $pos2 = strpos($buffer, $arg2);
                            $tmp = $buffer[$pos1];
                            $buffer[$pos1] = $buffer{$pos2};
                            $buffer[$pos2] = $tmp;
                            break;
                    }
                }
            }
            // optimization to skip passes when a pass matches the first pass
            if ($base === $buffer) {
                // skip the counter a multiple of the passes already done up to the total number passes
                $x += (floor($passes / $x) - 1) * $x;
            }
        }

        // return the buffer with applied commands
        return $buffer;
    }
}