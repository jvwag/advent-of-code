<?php

namespace jvwag\AdventOfCode;

use Psr\Log\LoggerInterface;

/**
 * Class AssignmentFactory
 *
 * @package jvwag\AdventOfCode
 */
class AssignmentFactory
{
    private $assignment_downloader;
    private $logger;

    /**
     * AssignmentFactory constructor.
     *
     * @param LoggerInterface $logger
     * @param AssignmentDownloader $assignment_downloader
     */
    public function __construct(LoggerInterface $logger, AssignmentDownloader $assignment_downloader)
    {
        $this->logger = $logger;
        $this->assignment_downloader = $assignment_downloader;
    }

    /**
     * @param $year
     * @param $day
     *
     * @return AssignmentInterface
     * @throws \DomainException
     * @throws \InvalidArgumentException
     * @throws \BadMethodCallException
     */
    public function create($year, $day): AssignmentInterface
    {
        $class = __NAMESPACE__ . "\\Year" . $year . "\\Day" . $day;
        if (!class_exists($class)) {
            throw new \BadMethodCallException("Day " . $day . " in " . $year . " not found");
        }

        /** @var AssignmentInterface $assignment */
        $assignment = new $class($this->logger);
        $data = $this->assignment_downloader->getAssignmentData($year, $day);
        $assignment->setInput($data);

        return $assignment;
    }
}
