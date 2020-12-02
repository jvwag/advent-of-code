<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests;

use jvwag\AdventOfCode\Assignment;
use PHPUnit\Framework\TestCase;

/**
 * Class AssignmentSolution
 * @package jvwag\AdventOfCode\Tests
 */
class AssignmentSolution
{
    /**
     * @param TestCase $test
     * @param Assignment $assignment
     */
    public static function assert(TestCase $test, Assignment $assignment): void
    {
        $namespace = __NAMESPACE__;
        $namespace = substr($namespace, 0, strrpos($namespace, "\\") + 1);
        $namespace = "|^" . preg_quote($namespace, "|") . "|";

        $base = get_class($assignment);
        $base = preg_replace($namespace, "", $base);
        $base = strtolower($base);
        $base = str_replace("\\", "-", $base);

        $solution_base = implode(DIRECTORY_SEPARATOR, [__DIR__, "..", "solutions", $base]);
        $downloads_base = implode(DIRECTORY_SEPARATOR, [__DIR__, "..", "downloads", $base]);


        $file_download = $downloads_base . ".txt";
        $file_solution1 = $solution_base . "-part1.txt";
        $file_solution2 = $solution_base . "-part2.txt";

        if (file_exists($file_download)) {
            $solution1 = null;
            if (file_exists($file_solution1)) {
                $solution1 = rtrim(file_get_contents($file_solution1));
            }
            $solution2 = null;
            if (file_exists($file_solution2)) {
                $solution2 = rtrim(file_get_contents($file_solution2));
            }

            if ($solution1 !== null || $solution2 !== null) {
                $assignment->setInput(file_get_contents($file_download));
                $output = $assignment->run();

                if ($solution1 !== null) {
                    $test::assertEquals($solution1, rtrim((string)$output[0]));
                } else {
                    $test::markTestIncomplete("Missing first solution for " . get_class($test));
                }
                if ($solution2) {
                    $test::assertEquals($solution2, rtrim((string)$output[1]));
                } else {
                    $test::markTestIncomplete("Missing second solution for " . get_class($test));
                }
            } else {
                $test::markTestIncomplete("Missing solutions for " . get_class($test));
            }
        } else {
            $test::markTestIncomplete("Missing download for " . get_class($test));
        }
    }
}