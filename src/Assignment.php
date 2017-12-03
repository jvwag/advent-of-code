<?php

namespace jvwag\AdventOfCode;


use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Class Assignment
 *
 * @package jvwag\AdventOfCode
 */
class Assignment implements AssignmentInterface
{
    protected $input = "";

    /** @var LoggerInterface */
    protected $logger;

    /**
     * Assignment constructor.
     *
     * @param LoggerInterface|null $logger
     */
    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger ?: new NullLogger();
    }

    /**
     * @return array
     */
    public function run(): array
    {
        return [null, null];
    }

    /**
     * @param string $input
     *
     * @return Assignment
     */
    public function setInput(string $input): self
    {
        $this->input = $input;

        return $this;
    }

    /**
     * @return string
     */
    public function getInput(): string
    {
        return $this->input;
    }
}
