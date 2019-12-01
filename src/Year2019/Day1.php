<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2019;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2019
 */
class Day1 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        $module_mass_list = explode("\n", trim($this->getInput()));
        $module_mass_list = array_map("intval", $module_mass_list);

        // return answers
        return
            [
                $this->run1($module_mass_list),
                $this->run2($module_mass_list)
            ];
    }

    public function run1(array $module_mass_list): int
    {
        $sum_mass = 0;
        // loop over all all module masses, calculate the fuel need and add to the sum
        foreach ($module_mass_list as $module_mass) {
            $sum_mass += $this->calcFuel($module_mass);
        }

        // return the sum of all fuel masses
        return $sum_mass;
    }

    private function run2(array $module_mass_list): int
    {
        $sum_mass = 0;
        // loop over all all module masses, calculate the fuel need and add to the sum
        foreach ($module_mass_list as $module_mass) {
            $sum_mass += $fuel_mass = $this->calcFuel($module_mass);

            // but also calculate the mass over the fuel, looping until the amount of fuel needed is too small
            while($fuel_mass > 0) {
                $sum_mass += $fuel_mass = $this->calcFuel($fuel_mass);
            }
        }

        // return the sum of all fuel masses
        return $sum_mass;
    }

    /**
     * Calculate fuel mass for a given module mass
     * 
     * Low mass will return 0 and no negative number
     *
     * @param int $module_mass Module mass
     * @return int Fuel mass
     */
    public function calcFuel(int $module_mass): int
    {
        return max(0, (int)floor($module_mass / 3) - 2);
    }
}