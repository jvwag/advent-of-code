<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2018;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2018
 */
class Day7 extends Assignment
{
    /** @var int ASCII Character Offset to 'A' */
    private const CHAR_OFFSET = 64;

    /** @var int Default Base Time */
    private const DEFAULT_BASE_TIME = 60;

    /** @var int Default Max Jobs */
    private const DEFAULT_MAX_JOBS = 5;

    /** @var int Base Time */
    private $base_time = self::DEFAULT_BASE_TIME;

    /** @var int Max Jobs */
    private $max_jobs = self::DEFAULT_MAX_JOBS;

    /**
     * @return array
     */
    public function run(): array
    {
        // get input
        $input = explode("\n", trim($this->getInput()));

        // loop over all lines, parsing the input
        foreach ($input as $line) {
            if (preg_match("/^Step (\S+) must be finished before step (\S+) can begin.$/", $line, $match)) {
                // node with children
                $nodes[$match[1]][] = $match[2];
                // possible node without children
                $nodes[$match[2]] = $nodes[$match[2]] ?? [];
            }
        }

        // sort the nodes by key (a..z)
        ksort($nodes);


        $output1 = "";
        $nodes1 = $nodes;
        // do until no nodes are left
        while ($nodes1) {
            // loop over all possible nodes
            foreach (array_keys($nodes1) as $node) {
                // determine if node has -no- children
                if (!in_array($node, array_reduce($nodes1, 'array_merge', []), true)) {
                    // add node to output
                    $output1 .= $node;
                    // remove node from node list
                    unset($nodes1[$node]);
                    // start searching from the start
                    break;
                }
            }
        }

        $output2 = 0;
        $jobs = [];
        $nodes2 = $nodes;
        // do until no nodes are left
        while ($nodes2) {
            // add workers until we have no more left
            while (count($jobs) < $this->getMaxJobs()) {
                $found_node = false;
                // loop over all possible nodes
                foreach (array_keys($nodes2) as $node) {
                    // determine if the node is not a job AND node has -no- children
                    if (!array_key_exists($node, $jobs) && !in_array($node, array_reduce($nodes2, 'array_merge', []), true)) {
                        // add the node to a job list for BASE_TIME + letter_value
                        $jobs[$node] = $this->getBaseTime() + ord($node) - self::CHAR_OFFSET;
                        // set marker that a node was found
                        $found_node = true;
                        break;
                    }
                }
                // if we have not found any nodes we should stop trying to allocate workers
                if (!$found_node) {
                    break;
                }
            }

            // attend to all jobs
            foreach ($jobs as $node => &$job) {
                // deduct one second from every job, and see if the job is done
                if (--$job === 0) {
                    // remove the node and the job from their lists
                    unset($nodes2[$node], $jobs[$node]);
                }
            }

            // unset job (used by reference)
            unset($job);

            // add one second to the timer
            $output2++;
        }

        // return answers
        return
            [
                $output1, // order of nodes
                $output2  // seconds until all jobs were done
            ];
    }

    /**
     * @return int
     */
    public function getBaseTime(): int
    {
        return $this->base_time;
    }

    /**
     * @param int $base_time
     */
    public function setBaseTime(int $base_time): void
    {
        $this->base_time = $base_time;
    }

    /**
     * @return int
     */
    public function getMaxJobs(): int
    {
        return $this->max_jobs;
    }

    /**
     * @param int $max_jobs
     */
    public function setMaxJobs(int $max_jobs): void
    {
        $this->max_jobs = $max_jobs;
    }

}