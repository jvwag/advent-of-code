<?php

namespace jvwag\AdventOfCode;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use GuzzleHttp\Psr7\Request;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class AssignmentDownloader
{
    const BASE_URL = "http://adventofcode.com/";

    const MIN_YEAR = 2015;
    const MAX_YEAR = 2050;

    const MIN_DAY = 1;
    const MAX_DAY = 25;

    /** @var string Contents of 'session' cookie on the adventofcode site */
    private $session;

    /** @var int Year of the advent calendar */
    private $year;

    /** @var ClientInterface HTTP Client Interface */
    private $http_client;

    /**
     * Downloader constructor.
     *
     * @param string $session Contents of 'session' cookie on the adventofcode site
     * @param int|null $year Year of the advent calendar
     * @param LoggerInterface|null $logger Logger
     * @param ClientInterface|null $http_client Guzzle HTTP Client interface
     *
     * @throws \Exception
     */
    public function __construct($year, $session, LoggerInterface $logger = null, ClientInterface $http_client = null)
    {
        $this->setSession($session);
        $this->setYear($year);

        if ($logger === null) {
            $this->logger = new NullLogger();
        } elseif ($logger instanceof LoggerInterface) {
            $this->logger = $logger;
        } else {
            throw new \Exception("This download requires a valid PSR LoggerInterface");
        }

        if ($http_client === null) {
            $this->http_client = new Client();
        } elseif ($http_client instanceof ClientInterface) {
            $this->http_client = $http_client;
        } else {
            throw new \Exception("This downloader requires a Guzzle HTTP ClientInterface");
        }
    }

    /**
     * Returns assignment data, if it is not cached it will be downloaded and cached.
     *
     * @param $day integer Day of the advent calendar
     *
     * @return string Assignment Data
     */
    function getAssignmentData($day)
    {
        $file = $this->getAssignmentFile($day, $this->getYear());

        if (!file_exists($file) || !filesize($file)) {
            $data = $this->downloadAssignmentData($day);
            $this->writeAssignmentData($file, $data);
        } else {
            $data = $this->readAssignmentData($file);
        }

        return $data;
    }

    /**
     * @param $day integer Day of the advent calendar
     *
     * @return string Contents of the assignment
     * @throws \Exception If the file could not be downloaded
     */
    public function downloadAssignmentData($day)
    {
        $day = $this->validateDay($day);
        $url = self::BASE_URL . $this->getYear() . "/day/" . $day . "/input";

        $cookie = new SetCookie();
        $cookie->setName("session");
        $cookie->setValue($this->getSession());
        $cookie->setDomain("adventofcode.com");
        $cookie->setPath("/");

        $jar = new CookieJar();
        $jar->setCookie($cookie);

        $request = new Request("GET", $url);

        try {
            $response = $this->http_client->send($request, ["cookies" => $jar]);
            $body = $response->getBody();
            $this->logger->info("Downloaded assignment", ["url" => $url, "status" => $response->getStatusCode(), "size" => strlen($body)]);
        } catch (\Exception $e) {
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
     * @throws \Exception If the file could not be read
     */
    public function readAssignmentData($file)
    {
        if (!file_exists($file)) {
            throw new \Exception("Assignment file does not exist");
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
     * @throws \Exception If the file is not written properly
     */
    private function writeAssignmentData($file, $content)
    {
        $size = file_put_contents($file, $content);
        if ($size === false || strlen($content) !== $size) {
            throw new \Exception("Error writing assignment data");
        }

        $this->logger->info("Written assignment", ["file" => $file, "size" => strlen($content)]);
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
    public function getAssignmentFile($day, $year)
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
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set the session to be used in the cookie in the request to the adventofcode website.
     *
     * @param string $session Contents of 'session' cookie on the adventofcode site
     *
     * @throws \InvalidArgumentException If the contents of the session string is not valid
     */
    public function setSession($session)
    {
        $this->session = $this->validateSession($session);
    }

    /**
     * Get the year of the adventofcode
     *
     * @return int Year of the adventofcode
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set the year of the adventofcode
     *
     * @param int $year Year of the adventofcode
     *
     * @throws \InvalidArgumentException If the year is invalid of out of bounds
     */
    public function setYear($year)
    {
        $this->year = $this->validateYear($year);
    }

    /**
     * Validate the day of the advent calendar to be an integer within bounds of MIN_DAY and MAX_DAY
     *
     * @param $day int Day of the advent calendar
     *
     * @throws \InvalidArgumentException If the day is invalid of out of bounds
     * @return int Validated day
     */
    public function validateDay($day)
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
    public function validateYear($year)
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
     */
    public function validateSession($session)
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
