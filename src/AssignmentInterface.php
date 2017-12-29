<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode;


/**
 * Interface AssignmentInterface
 *
 * @package jvwag\AdventOfCode
 */
interface AssignmentInterface
{
    /**
     * @return array
     */
    public function run(): array;

    /**
     * @param string $input
     *
     * @return mixed
     */
    public function setInput(string $input);

    /**
     * @return string
     */
    public function getInput(): string;
}
