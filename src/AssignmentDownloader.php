<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode;

use DomainException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;

/**
 * Class AssignmentDownloader
 *
 * @package jvwag\AdventOfCode
 */
class AssignmentDownloader
{


    /** @var ClientInterface HTTP Client Interface */
    private ClientInterface $http_client;

    /** @var LoggerInterface */
    private LoggerInterface $logger;

    /**
     * Downloader constructor.
     *
     * @param LoggerInterface $logger Logger
     * @param ClientInterface $http_client Guzzle HTTP Client interface
     *
     * @throws InvalidArgumentException On missing
     */
    public function __construct(LoggerInterface $logger, ClientInterface $http_client)
    {
        $this->logger = $logger;
        $this->http_client = $http_client;
    }

    /**
     * Returns assignment data, if it is not cached it will be downloaded and cached.
     *
     * @param int $year Year of the advent calendar
     * @param int $day Day of the advent calendar
     *
     * @return string Assignment Data
     * @throws DomainException
     * @throws InvalidArgumentException
     */
    public function getAssignmentData(int $year, int $day): string
    {
        $file = $this->getAssignmentFile($day, $year);

        if (!file_exists($file) || !filesize($file)) {
            $data = $this->downloadAssignmentData($year, $day);
            $this->writeAssignmentData($file, $data);
        } else {
            $data = $this->readAssignmentData($file);
        }

        return $data;
    }

    /**
     * @param int $year Year of the advent calendar
     * @param int $day Day of the advent calendar
     *
     * @return string Contents of the assignment
     * @throws InvalidArgumentException
     * @throws RequestException
     * @noinspection PhpDocMissingThrowsInspection
     */
    public function downloadAssignmentData(int $year, int $day): string
    {
        $path = "/" . $year . "/day/" . $day . "/input";

        try {
            /** @noinspection PhpUnhandledExceptionInspection */
            $response = $this->http_client->request("GET", $path);
            $body = $response->getBody();
            $this->logger->info("Downloaded assignment", ["path" => $path, "status" => $response->getStatusCode(), "size" => strlen((string)$body)]);
        } catch (RequestException  $e) {
            $this->logger->error($e->getMessage(), ["exception" => $e]);
            throw $e;
        }

        return (string)$body;
    }

    /**
     * Read the assignment data from a file
     *
     * @param $file string Name of the file to read from
     *
     * @return string Contents of the assignment
     * @throws DomainException If the file could not be read
     */
    public function readAssignmentData($file): string
    {
        if (!file_exists($file)) {
            throw new DomainException("Assignment file does not exist");
        }

        $content = file_get_contents($file);
        $this->logger->info("Read assignment", ["file" => $file, "size" => strlen($content)]);

        return $content;
    }

    /**
     * Write the assignment data to a file
     *
     * @param $file string Name of the file to write to
     * @param $content string Contents of the assignment
     *
     * @return AssignmentDownloader
     * @throws DomainException If the file is not written properly
     */
    private function writeAssignmentData($file, $content): self
    {
        $size = file_put_contents($file, $content);
        if ($size === false || strlen($content) !== $size) {
            throw new DomainException("Error writing assignment data");
        }

        $this->logger->info("Written assignment", ["file" => $file, "size" => strlen($content)]);

        return $this;
    }

    /**
     * Get assignment filename on local filesystem
     *
     * @param $day int|string Day number of the advent calendar
     * @param $year int|string Year of the advent calendar
     *
     * @return string Filename on local filesystem
     * @throws InvalidArgumentException If the day or year is not correct
     *
     */
    public function getAssignmentFile($day, $year): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "downloads" . DIRECTORY_SEPARATOR . "year" . $year . "-day" . $day . ".txt";
    }
}
