<?php

namespace jvwag\AdventOfCode;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Class AssignmentDownloader
 *
 * @package jvwag\AdventOfCode
 */
class AssignmentDownloader
{
    private const DOMAIN = "adventofcode.com";

    private const MIN_YEAR = 2015;
    private const MAX_YEAR = 2050;

    private const MIN_DAY = 1;
    private const MAX_DAY = 25;

    /** @var string Contents of 'session' cookie on the adventofcode site */
    private $session;

    /** @var ClientInterface HTTP Client Interface */
    private $http_client;

    /** @var LoggerInterface */
    private $logger;

    /**
     * Downloader constructor.
     *
     * @param string $session Contents of 'session' cookie on the adventofcode site
     * @param LoggerInterface|null $logger Logger
     * @param ClientInterface|null $http_client Guzzle HTTP Client interface
     *
     * @throws \InvalidArgumentException On missing
     */
    public function __construct($session, LoggerInterface $logger = null, ClientInterface $http_client = null)
    {
        $this->setSession($session);

        $this->logger = $logger;
        if ($logger === null) {
            $this->logger = new NullLogger();
        }

        $this->http_client = $http_client;
        if ($http_client === null) {
            $this->http_client = new Client();
        }
    }

    /**
     * Returns assignment data, if it is not cached it will be downloaded and cached.
     *
     * @param $year integer Year of the advent calendar
     * @param $day integer Day of the advent calendar
     *
     * @return string Assignment Data
     * @throws \DomainException
     * @throws \InvalidArgumentException
     */
    public function getAssignmentData($year, $day): string
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
     * @param $year integer Year of the advent calendar
     * @param $day integer Day of the advent calendar
     *
     * @return string Contents of the assignment
     * @throws \InvalidArgumentException
     */
    public function downloadAssignmentData(int $year, int $day): string
    {
        $day = $this->validateDay($day);
        $year = $this->validateYear($year);
        $url = "http://" . self::DOMAIN . "/" . $year . "/day/" . $day . "/input";

        $jar = CookieJar::fromArray([
            'session' => $this->getSession(),
        ], self::DOMAIN);

        try {
            $response = $this->http_client->request("GET", $url, ["cookies" => $jar]);
            $body = $response->getBody();
            $this->logger->info("Downloaded assignment", ["url" => $url, "status" => $response->getStatusCode(), "size" => \strlen($body)]);
        } catch (GuzzleException $e) {
            $new_exception = new \Exception("Error downloading file: " . $e->getMessage(), 0, $e);
            $this->logger->error($e->getMessage(), ["exception" => $new_exception]);
            throw new $new_exception;
        }

        return $body;
    }

    /**
     * Read the assignment data from a file
     *
     * @param $file string Name of the file to read from
     *
     * @return string Contents of the assignment
     * @throws \DomainException If the file could not be read
     */
    public function readAssignmentData($file): string
    {
        if (!file_exists($file)) {
            throw new \DomainException("Assignment file does not exist");
        }

        $content = file_get_contents($file);
        $this->logger->info("Read assignment", ["file" => $file, "size" => \strlen($content)]);

        return $content;
    }

    /**
     * Write the assignment data to a file
     *
     * @param $file string Name of the file to write to
     * @param $content string Contents of the assignment
     *
     * @return AssignmentDownloader
     * @throws \DomainException If the file is not written properly
     */
    private function writeAssignmentData($file, $content): self
    {
        $size = file_put_contents($file, $content);
        if ($size === false || \strlen($content) !== $size) {
            throw new \DomainException("Error writing assignment data");
        }

        $this->logger->info("Written assignment", ["file" => $file, "size" => \strlen($content)]);

        return $this;
    }

    /**
     * Get assignment filename on local filesystem
     *
     * @param $day int Day number of the advent calendar
     * @param $year int Year of the advent calendar
     *
     * @throws \InvalidArgumentException If the day or year is not correct
     *
     * @return string Filename on local filesystem
     */
    public function getAssignmentFile($day, $year): string
    {
        $day = $this->validateDay($day);
        $year = $this->validateYear($year);

        return __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "downloads" . DIRECTORY_SEPARATOR . "year" . $year . "-day" . $day . ".txt";
    }

    /**
     * Get the session to be used in the cookie in the request to the adventofcode website.
     *
     * @return string Contents of 'session' cookie on the adventofcode site
     */
    public function getSession(): string
    {
        return $this->session;
    }

    /**
     * Set the session to be used in the cookie in the request to the adventofcode website.
     *
     * @param string $session Contents of 'session' cookie on the adventofcode site
     *
     * @return AssignmentDownloader
     * @throws \InvalidArgumentException If the contents of the session string is not valid
     */
    public function setSession($session): self
    {
        $this->session = $this->validateSession($session);

        return $this;
    }

    /**
     * Validate the day of the advent calendar to be an integer within bounds of MIN_DAY and MAX_DAY
     *
     * @param $day int Day of the advent calendar
     *
     * @throws \InvalidArgumentException If the day is invalid of out of bounds
     * @return int Validated day
     */
    public function validateDay(int $day): int
    {
        $value = filter_var(
            $day,
            FILTER_VALIDATE_INT,
            [
                "options" => ["min_range" => self::MIN_DAY, "max_range" => self::MAX_DAY],
                "flags" => FILTER_FLAG_ALLOW_HEX | FILTER_FLAG_ALLOW_OCTAL,
            ]);

        if ($value === false) {
            throw new \InvalidArgumentException(sprintf("Day must be an integer in range of %d to %d", self::MIN_DAY, self::MAX_DAY));
        }

        return $value;
    }

    /**
     * Validate the year of the advent calendar to be an integer within bounds of MIN_YEAR and MAX_YEAR
     *
     * @param $year int Year of the advent calendar
     *
     * @throws \InvalidArgumentException If the year is invalid of out of bounds
     * @return int Validated year
     */
    public function validateYear(int $year): int
    {
        $value = filter_var(
            $year,
            FILTER_VALIDATE_INT,
            [
                "options" => ["min_range" => self::MIN_YEAR, "max_range" => self::MAX_YEAR],
                "flags" => FILTER_FLAG_ALLOW_HEX | FILTER_FLAG_ALLOW_OCTAL,
            ]);

        if ($value === false) {
            throw new \InvalidArgumentException(sprintf("Year must be an integer in range of %d to %d", self::MIN_YEAR, self::MAX_YEAR));
        }

        return $value;
    }

    /**
     * Validate a session string to be used in the cookie in the request to the adventofcode website.
     *
     * @param $session string Contents of a session cookie
     *
     * @return string Validated contents of a session cookie
     * @throws \InvalidArgumentException
     */
    public function validateSession(string $session): string
    {
        $value = filter_var(
            $session,
            FILTER_SANITIZE_STRING,
            [
                "options" => [],
                "flags" => FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH,
            ]);

        if ($value === false) {
            throw new \InvalidArgumentException("Invalid characters in session value");
        }

        return $value;
    }

}
