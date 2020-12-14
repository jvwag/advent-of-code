<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2020;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2020
 */
class Day13 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        $input = explode("\n", $this->getInput());
        $departure = intval(trim(array_shift($input)));
        $bus_numbers = array_map("intval", explode(",", trim(array_shift($input))));

        $next_bus = [];
        foreach ($bus_numbers as $bus) {
            if ($bus !== 0) {
                $next_bus[$bus] = ($departure - (ceil($departure / $bus) * $bus)) * -1;
            }
        }

        $minutes = min($next_bus);
        $bus = array_search(min($next_bus), $next_bus);

        // return answers
        return
            [
                intval($minutes * $bus),
                $this->run2($bus_numbers)
            ];
    }

    public function run2(array $bus_numbers): int
    {
        $first_bus_number = reset($bus_numbers);
        $bus_numbers = array_filter($bus_numbers, fn($x) => $x !== 0);

        $d = 0;

        // not too performance impacting progress indication
        $prev = 0;
        $a = 5;
        pcntl_signal(SIGALRM, function () use (&$d, &$prev, $a) {
            echo $d . " -> " . floor(($d - $prev) / $a) . PHP_EOL;
            pcntl_alarm($a);
            $prev = $d;
        }, true);
        pcntl_alarm($a);

        while (true) {
            $d += $first_bus_number;
            $first_bus_departure = null;
            foreach ($bus_numbers as $offset => $bus) {
                if ($bus !== 0) {
                    $next_bus_departure = (ceil($d / $bus) * $bus);
                    if ($first_bus_departure === null) {
                        $first_bus_departure = $next_bus_departure;
                        continue;
                    }
                    if ($next_bus_departure !== $first_bus_departure + $offset) {
                        continue 2;
                    }
                }
            }
            break;
        }

        return $d;
    }

}