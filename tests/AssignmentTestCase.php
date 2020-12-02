<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Class SolutionTestCase
 * @package jvwag\AdventOfCode\Tests
 */
abstract class AssignmentTestCase extends TestCase
{
    protected const TEST_CLASS = null;

    public function testSolution(): void
    {
        $class = $this::TEST_CLASS;
        AssignmentSolution::assert($this, new $class);
    }
}