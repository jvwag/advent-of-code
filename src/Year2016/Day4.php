<?php

namespace jvwag\AdventOfCode\Year2016;

use jvwag\AdventOfCode\Assignment;

/**
 * Class Day4
 *
 * @package jvwag\AdventOfCode\Year2016
 */
class Day4 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        $data = $this->getInput();
        $lines = explode("\n", trim($data));
        $sector_sum = 0;
        $hidden_sector = 0;

        foreach ($lines as $line) {
            if (preg_match("/^(.*)-(\d+)\[(.*)\]$/", $line, $match)) {
                /** @noinspection PhpUnusedLocalVariableInspection */
                [$tmp, $name, $sector, $checksum] = $match;

                $data = count_chars(str_replace("-", "", $name), 1);
                $keys = array_keys($data);
                array_multisort($data, SORT_DESC, array_keys($data), SORT_ASC, $data, $keys);
                $data = array_combine($keys, $data);

                $check = implode("", array_map("\\chr", \array_slice(array_keys($data), 0, 5)));

                $decrypted_name = "";
                if ($checksum === $check) {
                    $sector_sum += $sector;
                    foreach (str_split($name) as $c) {
                        $decrypted_name .= $c !== "-" ? \chr(((\ord($c) - 97 + $sector) % 26) + 97) : "-";
                    }
                    if ($decrypted_name === "northpole-object-storage") {
                        $hidden_sector = $sector;
                    }
                }
            }
        }


        return
            [
                $sector_sum,
                $hidden_sector,
            ];
    }
}
