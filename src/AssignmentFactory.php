<?php

namespace jvwag\AdventOfCode;

class AssignmentFactory extends AssignmentController
{
    /**
     * @param $year
     * @param $day
     *
     * @return AssignmentInterface
     * @throws \Exception
     */
    public function create($year, $day)
    {
        $class = __NAMESPACE__ . "\\Year" . $year . "\\Day" . $day;
        if(!class_exists($class))
            throw new \Exception("Day ".$day." in ".$year." not found");

        return new $class($this->assignment_downloader, $this->logger, $this->http_client);
    }
}
