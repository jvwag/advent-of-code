<?php

namespace jvwag\AdventOfCode;

use GuzzleHttp\ClientInterface;
use Psr\Log\LoggerInterface;

abstract class AssignmentController
{
    /** @var AssignmentDownloader */
    protected $assignment_downloader;

    /** @var LoggerInterface */
    protected $logger;

    /** @var ClientInterface */
    protected $http_client;

    public function __construct(AssignmentDownloader $assignment_downloader, LoggerInterface $logger, ClientInterface $http_client)
    {
        $this->assignment_downloader = $assignment_downloader;
        $this->logger = $logger;
        $this->http_client = $http_client;
    }
}
