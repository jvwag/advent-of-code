<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode;

use BadMethodCallException;
use DomainException;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;

/**
 * Class AssignmentFactory
 *
 * @package jvwag\AdventOfCode
 */
class AssignmentFactory
{
    private AssignmentDownloader $assignment_downloader;
    private LoggerInterface $logger;

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
     * @throws DomainException
     * @throws InvalidArgumentException
     * @throws BadMethodCallException
     */
    public function create($year, $day): AssignmentInterface
    {
        $class = $this->findAssignment($year, $day);

        /** @var AssignmentInterface $assignment */
        $assignment = new $class($this->logger);

        $data = "";
        if (defined($class . "::INPUT_LOCATION")) {
            $filename = __DIR__ . "/../downloads/" . constant($class . "::INPUT_LOCATION");
            if (file_exists($filename)) {
                $data = file_get_contents($filename);
            }
        } else {
            $data = $this->assignment_downloader->getAssignmentData($year, (int)$day);
        }

        $assignment->setInput($data);

        return $assignment;
    }

    private function findAssignment($year, $name): string
    {
        $classes = [
            __NAMESPACE__ . "\\Year" . $year . "\\Day" . $name,
            __NAMESPACE__ . "\\Year" . $year . "\\" . $name,
        ];

        foreach ($classes as $class) {
            if (class_exists($class)) {
                return $class;
            }
        }

        throw new BadMethodCallException("Assignment not found");
    }
}